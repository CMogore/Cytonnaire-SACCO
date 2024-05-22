<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;

class ProcessShareTransfers extends Command
{
    protected $signature = 'shares:process-transfers';
    protected $description = 'Process share transfers and update shares';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $shareTransfers = DB::table('share_transfers')->whereNull('deleted_at')->get();

        foreach ($shareTransfers as $transfer) {
            $senderShares = DB::table('shares')->where('user_id', $transfer->from_user_id)->value('total_shares');
            $receiverShares = DB::table('shares')->where('user_id', $transfer->to_user_id)->value('total_shares');

            // Update sender's shares
            DB::table('shares')->where('user_id', $transfer->from_user_id)->update([
                'total_shares' => $senderShares - $transfer->amount,
                'updated_at' => now()
            ]);

            // Update receiver's shares
            if ($receiverShares !== null) {
                DB::table('shares')->where('user_id', $transfer->to_user_id)->update([
                    'total_shares' => $receiverShares + $transfer->amount,
                    'updated_at' => now()
                ]);
            } else {
                DB::table('shares')->insert([
                    'user_id' => $transfer->to_user_id,
                    'total_shares' => $transfer->amount,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Soft delete the transfer
            DB::table('share_transfers')->where('id', $transfer->id)->update([
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);

            // Soft delete the sender
            DB::table('users')->where('id', $transfer->from_user_id)->update([
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('Share transfers have been processed.');
    }
}