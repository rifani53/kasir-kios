def normalisasi(bil1, bil2):
    total = bil1 + bil2
    normalisasi_bil1 = bil1 / total
    normalisasi_bil2 = bil2 / total
    return round(normalisasi_bil1, 2), round(normalisasi_bil2, 2)

bil1 = int(input())
bil2 = int(input())

hasil1, hasil2 = normalisasi(bil1, bil2)
print(f"{hasil1:.2f}")
print(f"{hasil2:.2f}")

