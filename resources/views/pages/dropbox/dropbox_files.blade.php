@extends('layouts.main')

@section('content')
<div style="font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto;">
    <h1 style="text-align: center; color: #333;">File Laporan di Dropbox</h1>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f4f4f4; text-align: left;">
                <th style="padding: 10px; border: 1px solid #ddd;">File Name</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Temporary Link</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Download</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $file['name'] }}</td>
                <td style="padding: 10px; border: 1px solid #ddd;">
                    <button onclick="generateLink('{{ route('pages.dropbox.temporary-link', ['filePath' => $file['name']]) }}')"
                        style="padding: 5px 10px; color: #fff; background-color: #007bff; border: none; border-radius: 5px; cursor: pointer;">
                        Generate Link
                    </button>
                </td>
                <td style="padding: 10px; border: 1px solid #ddd;">
                    <a href="{{ route('pages.dropbox.download', ['fileName' => $file['name']]) }}"
                        style="padding: 5px 10px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
                        Download
                    </a>
                </td>
                <td style="padding: 10px; border: 1px solid #ddd;">
                    <form action="{{ route('pages.dropbox.delete', ['fileName' => $file['name']]) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus file ini?')"
                            style="padding: 5px 10px; color: #fff; background-color: #dc3545; border: none; border-radius: 5px; cursor: pointer;">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Kotak untuk menampilkan Temporary Link -->
    <div id="link-box" style="margin-top: 20px; display: none; padding: 15px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px;">
        <strong>Temporary Link:</strong>
        <p id="temporary-link" style="margin: 10px 0; font-size: 14px; word-break: break-all;">
            <!-- Temporary Link akan ditampilkan di sini -->
        </p>
        <a href="#" id="open-link" target="_blank"
           style="padding: 5px 10px; color: #fff; background-color: #28a745; text-decoration: none; border-radius: 5px;">
            Open Link
        </a>
    </div>
</div>

<script>
    function generateLink(url) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Menampilkan kotak link
                const linkBox = document.getElementById('link-box');
                const temporaryLink = document.getElementById('temporary-link');
                const openLink = document.getElementById('open-link');

                // Mengisi data link
                temporaryLink.textContent = data.temporary_link;
                openLink.href = data.temporary_link;

                // Menampilkan kotak
                linkBox.style.display = 'block';
            })
            .catch(error => {
                alert('Gagal mendapatkan link. Silakan coba lagi.');
                console.error(error);
            });
    }
</script>
@endsection
