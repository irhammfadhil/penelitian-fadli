<?php

namespace App\Services;
use App\Models\Diagnosis;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Highcharts\Highcharts;
use Symfony\Component\Process\Process;

class ExportGraphService {
    public function exportRTIGraph($id) {
        $sum_gigi_tetap = Diagnosis::where('users_id', '=', $id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [11, 48])->count();
        $sum_gigi_sulung = Diagnosis::where('users_id', '=', $id)->where('is_decay', '=', 1)->whereBetween('id_gigi', [51, 85])->count();

        $rti_index = 0;
        $rti_index_sulung = 0;

        $userData = User::find($id);

        if($userData->dmft_score == 0 || !$userData->dmft_score) {
            $rti_index = 0;
        }
        else {
            $rti_index = ($sum_gigi_tetap / $userData->dmft_score)*100;
        }
        if($userData->deft_score == 0 || !$userData->deft_score) {
            $rti_index_sulung = 0;
        }
        else {
            $rti_index_sulung = ($sum_gigi_sulung / $userData->deft_score)*100;
        }
        return [
            'rti_index' => $rti_index,
            'rti_index_sulung' => $rti_index_sulung,
        ];
    }
}