<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Result;
use App\Models\CareerSuggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Informasi;

class TesMinatController extends Controller
{
    public function index()
{
    $user = auth()->user();

    // Cek apakah user sudah pernah mengikuti tes
    $hasResult = Result::where('user_id', $user->id)->exists();

    if ($hasResult) {
        return redirect()->route('tes-minat.hasil');
    }

    $informasi = Informasi::first();

    // Notifikasi
    $beritaforummateriNotifications = collect();
    $chatNotifications = collect();

    if ($user) {
        $beritaforummateriNotifications = $user->notifications()
            ->whereIn('type', ['App\Notifications\NewBeritaNotification', 'App\Notifications\NewForumNotification', 'App\Notifications\NewMateriNotification'])
            ->latest()
            ->take(5)
            ->get();

        $chatNotifications = $user->notifications()
            ->where('type', 'App\Notifications\NewChatNotification')
            ->latest()
            ->get()
            ->unique('data.from_id');
    }

    $questions = Question::all();

    return view('tes-minat.index', [
        'currentUser' => $user,
        'informasi' => $informasi,
        'questions' => $questions,
        'beritaforummateriNotifications' => $beritaforummateriNotifications,
        'chatNotifications' => $chatNotifications,
    ]);
}

    public function store(Request $request)
    {
        $user = Auth::user();

        // Cegah jika user sudah mengisi
    if (Result::where('user_id', $user->id)->exists()) {
        return redirect()->route('tes-minat.hasil')->with('message', 'Tes sudah pernah diisi.');
    }

        // Hapus jawaban sebelumnya (jika ada)
        Answer::where('user_id', $user->id)->delete();

        // Simpan semua jawaban baru
        foreach ($request->jawaban as $question_id => $jawaban) {
            Answer::create([
                'user_id' => $user->id,
                'question_id' => $question_id,
                'jawaban' => $jawaban,
            ]);
        }

        // Hitung hasil
        $skor = Answer::select('questions.kode_riasec', DB::raw('SUM(jawaban) as total'))
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->where('answers.user_id', $user->id)
            ->groupBy('questions.kode_riasec')
            ->pluck('total', 'kode_riasec');

        // Simpan hasil
        Result::where('user_id', $user->id)->delete();
        foreach ($skor as $kode => $nilai) {
            Result::create([
                'user_id' => $user->id,
                'kode_riasec' => $kode,
                'skor' => $nilai,
            ]);
        }

        return redirect()->route('tes-minat.hasil');
    }

    public function hasil()
    {
        $user = Auth::user();
        $results = Result::where('user_id', $user->id)->orderByDesc('skor')->get();
        $topKode = optional($results->first())->kode_riasec;
        $suggestion = CareerSuggestion::where('kode_riasec', $topKode)->first();

        $informasi = Informasi::first();
        // Inisialisasi variabel untuk notifikasi
        $beritaforummateriNotifications = collect();
        $chatNotifications = collect();

        // Periksa apakah pengguna sudah login
        if (auth()->check()) {
            $userNotif = auth()->user();

            // Ambil notifikasi berita dan forum
            $beritaforummateriNotifications = $userNotif->notifications()
                ->whereIn('type', ['App\Notifications\NewBeritaNotification', 'App\Notifications\NewForumNotification', 'App\Notifications\NewMateriNotification'])
                ->latest()
                ->take(5)
                ->get();

            // Ambil notifikasi chat
            $chatNotifications = $userNotif->notifications()
                ->where('type', 'App\Notifications\NewChatNotification')
                ->latest()
                ->get()
                ->unique('data.from_id');
        }

        // return view('tes-minat.hasil', compact('results', 'suggestion'));

        return view('tes-minat.hasil', [
            'currentUser' => auth()->user(),
            'informasi' => $informasi,
            'results' => $results,
            'suggestion' => $suggestion,
            'beritaforummateriNotifications' => $beritaforummateriNotifications,
            'chatNotifications' => $chatNotifications,
        ]);
    }

    public function ulangTes(Request $request)
    {
        $user = Auth::user();

        // Hapus hasil dan jawaban sebelumnya
        Answer::where('user_id', $user->id)->delete();
        Result::where('user_id', $user->id)->delete();

        return redirect()->route('tes-minat.index')->with('message', 'Tes berhasil diulang. Silakan isi kembali.');
    }

}
