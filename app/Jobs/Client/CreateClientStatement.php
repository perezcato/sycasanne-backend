<?php

namespace App\Jobs\Client;

use App\Http\Requests\Client\ClientStatementRequest;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class CreateClientStatement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $userRequest;

    /**
     * Create a new job instance.
     *
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->userRequest = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdfs.client-statement');
        $filename = Str::random(14);
        $pdf->save(storage_path()."/app/public/{$filename}.pdf");
    }
}
