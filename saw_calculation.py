import json
import numpy as np

# Fungsi untuk membaca data dari file JSON
def load_data(file_path):
    try:
        with open(file_path, 'r') as f:
            return json.load(f)
    except FileNotFoundError:
        print(f"File {file_path} tidak ditemukan.")
        return []

# Fungsi untuk menyimpan data ke file JSON
def save_data(file_path, data):
    with open(file_path, 'w') as f:
        json.dump(data, f, indent=4)

# Baca data JSON
data = load_data('storage/app/products.json')

# Pastikan data tidak kosong
if not data:
    print("Tidak ada data produk untuk diproses.")
else:
    # Kriteria dan bobot
    criteria = ['price', 'total_sold', 'total_transactions']
    weights = [0.3, 0.4, 0.3]  # Bobot kriteria (pastikan total = 1)

    # Matriks keputusan
    matrix = []
    for product in data:
        # Pastikan setiap produk memiliki kriteria yang diperlukan
        if all(key in product for key in criteria):
            matrix.append([product['price'], product['total_sold'], product['total_transactions']])
        else:
            print(f"Data produk {product} tidak lengkap, kunci yang dibutuhkan tidak ditemukan.")
            continue

    # Pastikan matriks tidak kosong
    if not matrix:
        print("Tidak ada data yang valid untuk perhitungan SAW.")
    else:
        # Normalisasi Matriks
        matrix = np.array(matrix)
        normalized_matrix = np.zeros(matrix.shape)

        # Normalisasi kriteria
        for j in range(matrix.shape[1]):
            if criteria[j] == 'price':  # Kriteria cost
                normalized_matrix[:, j] = matrix[:, j].min() / matrix[:, j]
            else:  # Kriteria benefit
                normalized_matrix[:, j] = matrix[:, j] / matrix[:, j].max()

        # Hitung skor SAW
        scores = np.dot(normalized_matrix, weights)

        # Gabungkan skor dengan produk
        results = []
        for i, product in enumerate(data):
            product['score'] = scores[i]  # Menambahkan skor ke setiap produk
            results.append(product)

        # Urutkan berdasarkan skor
        results = sorted(results, key=lambda x: x['score'], reverse=True)

        # Simpan hasil ke JSON
        save_data('storage/app/results.json', results)

        # Menampilkan hasil untuk pengecekan
        print("Hasil perhitungan SAW:")
        for result in results:
            print(result)
