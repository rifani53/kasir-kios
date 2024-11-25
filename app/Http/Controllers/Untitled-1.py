import numpy as np

def topsis():
    # Input jumlah alternatif dan kriteria
    while True:
        try:
            num_alternatives, num_criteria = map(int, input().split())
            if num_alternatives > 0 and num_criteria > 0:
                break
        except ValueError:
            pass

    # Input bobot
    while True:
        try:
            weights = np.array(list(map(float, input().split())))
            if len(weights) == num_criteria and all(w >= 0 for w in weights):
                weights /= weights.sum()  # Normalisasi bobot agar jumlah = 1
                break
        except ValueError:
            pass

    # Input tipe kriteria (B atau C)
    while True:
        criteria_type = input().strip().split()
        if len(criteria_type) == num_criteria and all(c.upper() in ['B', 'C'] for c in criteria_type):
            benefit_criteria = [c.upper() == 'B' for c in criteria_type]
            break

    # Input matriks keputusan
    decision_matrix = []
    for i in range(num_alternatives):
        while True:
            try:
                row = list(map(float, input().split()))
                if len(row) == num_criteria:
                    decision_matrix.append(row)
                    break
            except ValueError:
                pass
    decision_matrix = np.array(decision_matrix)

    # Proses TOPSIS
    col_criteria_reference = decision_matrix[0]  # Referensi baris pertama
    decision_matrix = decision_matrix / col_criteria_reference  # Skalakan terhadap referensi

    normalized_matrix = decision_matrix / np.sqrt((decision_matrix**2).sum(axis=0))  # Normalisasi
    weighted_matrix = normalized_matrix * weights  # Matriks terbobot

    # Solusi ideal positif (SIP) dan negatif (SIN)
    ideal_positive = np.array([
        weighted_matrix[:, j].max() if benefit_criteria[j] else weighted_matrix[:, j].min()
        for j in range(num_criteria)
    ])
    ideal_negative = np.array([
        weighted_matrix[:, j].min() if benefit_criteria[j] else weighted_matrix[:, j].max()
        for j in range(num_criteria)
    ])

    # Jarak ke SIP dan SIN
    distance_positive = np.sqrt(((weighted_matrix - ideal_positive)**2).sum(axis=1))
    distance_negative = np.sqrt(((weighted_matrix - ideal_negative)**2).sum(axis=1))

    # Nilai preferensi
    preference_scores = distance_negative / (distance_positive + distance_negative)

    # Urutan alternatif
    ranked_alternatives = sorted(zip(range(1, num_alternatives + 1), preference_scores), key=lambda x: x[1], reverse=True)

    # Output
    print("Nilai preferensi:", ' '.join(f"{score:.4f}" for _, score in ranked_alternatives))
    print("Urutan Alternatif:", ' '.join(str(alt) for alt, _ in ranked_alternatives))

topsis()
