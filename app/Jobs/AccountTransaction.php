<?php

namespace App\Jobs;

use App\Models\Account;
use App\Models\Statement;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class AccountTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        $account = Account::find($this->data['account']->id);

        DB::transaction(function () use($account) {
            Statement::create([
                'account_id'        => $this->data['account']->id,
                'amount'            => $this->data['amount'],
                'statement_type_id' => $this->data['statement_type_id']
            ]);

            if ($this->data['statement_type_id'] === 2) {
                $account->validateBalance($this->data['amount']);

                $account->balance -= $this->data['amount'];
            }
            elseif ($this->data['statement_type_id'] === 1) $account->balance += $this->data['amount'];

            $account->save();
        });
    }

    public function failed(Throwable $exception)
    {
        // Enviar email informando a falha da solicitação da transação
    }
}
