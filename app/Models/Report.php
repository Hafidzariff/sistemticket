<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelapor',
        'departemen',
        'tanggal_laporan',
        'jenis_masalah',
        'deskripsi',
        'status',
        'tanggal_selesai',
        'catatan_teknisi',
        'foto', // ← wajib ditambahkan
    ];
}
