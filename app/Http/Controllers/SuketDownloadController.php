<?php

namespace App\Http\Controllers;

use App\Models\Suket;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class SuketDownloadController extends Controller
{ 
    public function download(Suket $record)
    {
        
        $customer = new Buyer([
            'nomor_pengajuan_hidden' => $record->nomor_pengajuan_hidden,
            'nomor_suket_hidden' => $record->nomor_suket_hidden,
            'pemohon_nama' => $record->pemohon_nama,
            'pemohon_no_hp' => $record->pemohon_no_hp,
            'pemohon_jenis_kelamin' => $record->pemohon_jenis_kelamin,
            'pemohon_tempat_lahir' => $record->pemohon_tempat_lahir,
            'pemohon_tanggal_lahir' => $record->pemohon_tanggal_lahir,
            'pemohon_kewarganegaraan' => $record->pemohon_kewarganegaraan,
            'pemohon_status_perkawinan' => $record->pemohon_status_perkawinan,
            'pemohon_pekerjaan' => $record->pemohon_pekerjaan,
            'pemohon_agama' => $record->pemohon_agama,
            'pemohon_alamat' => $record->pemohon_alamat,
            'ktp_no' => $record->ktp_no,
            'kk_seumur_hidup' => $record->kk_seumur_hidup,
            'ktp_berlaku_hingga' => $record->ktp_berlaku_hingga,
            'ktp_file' => $record->ktp_file,
            'ktp_verified' => $record->ktp_verified,
            'kk_no' => $record->kk_no,
            'kk_keluar' => $record->kk_keluar,
            'kk_file' => $record->kk_file,
            'kk_verified' => $record->kk_verified,
            'surat_pengantar_rt' => $record->surat_pengantar_rt,
            'surat_pengantar_rw' => $record->surat_pengantar_rw,
            'surat_pengantar_nomor' => $record->surat_pengantar_nomor,
            'surat_pengantar_tanggal' => $record->surat_pengantar_tanggal,
            'surat_pengantar_file' => $record->surat_pengantar_file,
            'surat_pengantar_verified' => $record->surat_pengantar_verified,
            'keperluan' => $record->keperluan,
            'is_verified' => $record->is_verified,
            'status_suket_hidden' => $record->status_suket_hidden,
            'created_at' => $record->created_at,
            'updated_at' => $record->updated_at,
        ]);

        $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->buyer($customer)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(1.99)
            ->addItem($item)
            ->logo(asset('icon.png'));

        return $invoice->stream();
    }
}
