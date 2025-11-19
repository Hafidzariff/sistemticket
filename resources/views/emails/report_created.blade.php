<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Baru Helpdesk Surabraja</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px;">

        <h2 style="color: #007bff;">📢 Laporan Baru Diterima</h2>

        <p>Halo Admin,</p>
        <p>Ada laporan baru yang dikirim melalui sistem Helpdesk Surabraja:</p>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="font-weight: bold; width: 150px;">Nama Pelapor:</td>
                <td>{{ $report->nama_pelapor }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Departemen:</td>
                <td>{{ $report->departemen }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Jenis Masalah:</td>
                <td>{{ $report->jenis_masalah }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Deskripsi:</td>
                <td>{{ $report->deskripsi }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tanggal:</td>
                <td>{{ $report->created_at->format('d M Y H:i') }}</td>
            </tr>
        </table>

        <p style="margin-top: 20px;">Segera periksa di halaman admin untuk menindaklanjuti laporan ini.</p>

        <a href="{{ url('/admin/reports') }}" style="display:inline-block; background-color:#007bff; color:white; padding:10px 15px; text-decoration:none; border-radius:4px;">
            🔍 Lihat Detail Laporan
        </a>

        <p style="margin-top: 30px; font-size: 12px; color: #6c757d;">Email ini dikirim otomatis oleh sistem Helpdesk Surabraja.</p>
    </div>
</body>
</html>
