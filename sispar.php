<?php
session_start();

// Knowledge Base Class
class KnowledgeBase {
    
    public static function getRecommendations($formData) {
        $recommendations = [
            'recommended' => [],
            'avoid' => [],
            'tips' => [],
            'portions' => '',
            'meals' => [
                'breakfast' => [],
                'lunch' => [],
                'dinner' => [],
                'snacks' => []
            ]
        ];

        // Base recommendations by age
        if ($formData['ageGroup'] === 'remaja') {
            $recommendations['recommended'] = array_merge($recommendations['recommended'], [
                'Susu dan produk olahan (keju, yogurt)',
                'Daging tanpa lemak (ayam, ikan)',
                'Telur',
                'Sayuran hijau (bayam, brokoli)',
                'Buah-buahan segar',
                'Kacang-kacangan',
                'Nasi merah atau oatmeal'
            ]);
            $recommendations['portions'] = '3 kali makan utama + 2 snack sehat';
            
            $recommendations['meals']['breakfast'] = [
                'Oatmeal dengan buah dan kacang',
                'Telur dadar + roti gandum + susu',
                'Nasi merah + ayam + sayur'
            ];
            $recommendations['meals']['lunch'] = [
                'Nasi merah + ikan bakar + tumis brokoli',
                'Pasta gandum + daging ayam + salad',
                'Nasi + tempe goreng + sayur bening'
            ];
            $recommendations['meals']['dinner'] = [
                'Sup ayam + kentang + wortel',
                'Ikan panggang + quinoa + sayuran kukus',
                'Nasi merah + tahu bacem + capcay'
            ];
            $recommendations['meals']['snacks'] = [
                'Yogurt dengan granola',
                'Buah potong segar',
                'Kacang almond',
                'Smoothie pisang susu'
            ];
        } 
        elseif ($formData['ageGroup'] === 'dewasa') {
            $recommendations['recommended'] = array_merge($recommendations['recommended'], [
                'Ikan (salmon, tuna, makarel)',
                'Daging tanpa lemak',
                'Sayuran beragam',
                'Buah-buahan',
                'Biji-bijian utuh',
                'Kacang-kacangan dan biji-bijian',
                'Alpukat'
            ]);
            $recommendations['portions'] = '3 kali makan utama dengan porsi seimbang';
            
            $recommendations['meals']['breakfast'] = [
                'Telur rebus + alpukat + roti gandum',
                'Smoothie bowl dengan chia seeds',
                'Nasi merah + ikan + sayur'
            ];
            $recommendations['meals']['lunch'] = [
                'Salmon panggang + quinoa + brokoli',
                'Nasi merah + ayam panggang + salad',
                'Pasta gandum + tumis sayuran + tuna'
            ];
            $recommendations['meals']['dinner'] = [
                'Sup sayuran + dada ayam',
                'Ikan bakar + kentang panggang + asparagus',
                'Tahu tempe + tumis kangkung + nasi merah'
            ];
            $recommendations['meals']['snacks'] = [
                'Kacang mixed',
                'Greek yogurt',
                'Buah segar',
                'Dark chocolate 70%'
            ];
        } 
        elseif ($formData['ageGroup'] === 'lansia') {
            $recommendations['recommended'] = array_merge($recommendations['recommended'], [
                'Ikan berlemak (omega-3)',
                'Sayuran lunak dan mudah dicerna',
                'Buah-buahan lunak',
                'Sup kaldu tulang',
                'Bubur atau nasi lembek',
                'Telur rebus',
                'Yogurt'
            ]);
            $recommendations['portions'] = '4-5 kali makan dengan porsi kecil';
            
            $recommendations['meals']['breakfast'] = [
                'Bubur ayam + telur rebus',
                'Oatmeal lembut + pisang',
                'Nasi tim + ikan + sayur lunak'
            ];
            $recommendations['meals']['lunch'] = [
                'Sup ikan + kentang tumbuk',
                'Nasi lembek + ayam rebus + sayur kukus',
                'Bubur kacang hijau + roti tawar'
            ];
            $recommendations['meals']['dinner'] = [
                'Sup kaldu tulang + wortel lunak',
                'Nasi tim + telur + bayam',
                'Bubur ayam + sayuran lunak'
            ];
            $recommendations['meals']['snacks'] = [
                'Yogurt plain',
                'Pisang lunak',
                'Jus buah tanpa gula',
                'Puding susu'
            ];
        }

        // Adjust for activity level
        if ($formData['activityLevel'] === 'tinggi') {
            $recommendations['recommended'] = array_merge($recommendations['recommended'], [
                'Karbohidrat kompleks tambahan',
                'Protein tinggi',
                'Pisang'
            ]);
            $recommendations['tips'][] = 'Konsumsi protein 1.2-1.6g per kg berat badan';
            $recommendations['tips'][] = 'Minum air minimal 3 liter per hari';
        } 
        elseif ($formData['activityLevel'] === 'sedang') {
            $recommendations['tips'][] = 'Konsumsi protein 1g per kg berat badan';
            $recommendations['tips'][] = 'Minum air 2-2.5 liter per hari';
        } 
        else {
            $recommendations['tips'][] = 'Konsumsi protein 0.8g per kg berat badan';
            $recommendations['tips'][] = 'Minum air minimal 2 liter per hari';
            $recommendations['avoid'][] = 'Karbohidrat berlebih';
        }

        // Adjust for health conditions
        if (in_array('diabetes', $formData['healthConditions'])) {
            $recommendations['avoid'] = array_merge($recommendations['avoid'], [
                'Gula dan makanan manis',
                'Nasi putih',
                'Roti putih',
                'Minuman bersoda'
            ]);
            $recommendations['recommended'][] = 'Makanan indeks glikemik rendah';
            $recommendations['tips'][] = 'Batasi karbohidrat sederhana';
            $recommendations['tips'][] = 'Perbanyak serat';
        }

        if (in_array('hipertensi', $formData['healthConditions'])) {
            $recommendations['avoid'] = array_merge($recommendations['avoid'], [
                'Makanan tinggi garam',
                'Makanan olahan',
                'Fast food',
                'Daging merah berlebih'
            ]);
            $recommendations['recommended'] = array_merge($recommendations['recommended'], [
                'Sayuran hijau',
                'Pisang (potasium)',
                'Bawang putih'
            ]);
            $recommendations['tips'][] = 'Batasi garam < 5g per hari';
        }

        if (in_array('kolesterol', $formData['healthConditions'])) {
            $recommendations['avoid'] = array_merge($recommendations['avoid'], [
                'Gorengan',
                'Santan kental',
                'Jeroan',
                'Kulit ayam',
                'Mentega'
            ]);
            $recommendations['recommended'] = array_merge($recommendations['recommended'], [
                'Oatmeal',
                'Kacang almond',
                'Ikan berlemak'
            ]);
            $recommendations['tips'][] = 'Pilih minyak zaitun untuk memasak';
        }

        if (in_array('asam-urat', $formData['healthConditions'])) {
            $recommendations['avoid'] = array_merge($recommendations['avoid'], [
                'Jeroan',
                'Seafood tertentu (kerang, udang)',
                'Daging merah',
                'Alkohol'
            ]);
            $recommendations['recommended'] = array_merge($recommendations['recommended'], [
                'Ceri',
                'Vitamin C',
                'Air putih banyak'
            ]);
            $recommendations['tips'][] = 'Hindari makanan tinggi purin';
        }

        if (in_array('maag', $formData['healthConditions'])) {
            $recommendations['avoid'] = array_merge($recommendations['avoid'], [
                'Makanan pedas',
                'Makanan asam',
                'Kopi',
                'Cokelat',
                'Minuman bersoda'
            ]);
            $recommendations['recommended'] = array_merge($recommendations['recommended'], [
                'Makanan lunak',
                'Bubur',
                'Pisang',
                'Pepaya'
            ]);
            $recommendations['tips'][] = 'Makan dalam porsi kecil tapi sering';
        }
        
        // Logika untuk 'alergi' telah dihapus

        return $recommendations;
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $formData = [
        'ageGroup' => $_POST['ageGroup'] ?? '',
        'activityLevel' => $_POST['activityLevel'] ?? '',
        'healthConditions' => $_POST['healthConditions'] ?? []
    ];
    
    // Pastikan 'healthConditions' selalu array, minimal berisi 'sehat' jika tidak ada yang lain dipilih
    if (empty($formData['healthConditions'])) {
        $formData['healthConditions'] = ['sehat'];
    } elseif (count($formData['healthConditions']) > 1 && in_array('sehat', $formData['healthConditions'])) {
         // Hapus 'sehat' jika ada kondisi lain yang dipilih
         $formData['healthConditions'] = array_diff($formData['healthConditions'], ['sehat']);
    }

    $_SESSION['recommendations'] = KnowledgeBase::getRecommendations($formData);
    $_SESSION['formData'] = $formData;
    header('Location: ' . $_SERVER['PHP_SELF'] . '?show=result');
    exit;
}

// Reset
if (isset($_GET['reset'])) {
    unset($_SESSION['recommendations']);
    unset($_SESSION['formData']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$showResult = isset($_GET['show']) && $_GET['show'] === 'result' && isset($_SESSION['recommendations']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Rekomendasi Makanan</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍽 Sistem Pakar Rekomendasi Makanan</h1>
            <p>Dapatkan rekomendasi makanan sesuai kondisi kesehatan Anda</p>
        </div>
        
        <?php if (!$showResult): ?>
        <div class="card">
            <h2 style="text-align: center; margin-bottom: 10px;">Form Konsultasi</h2>
            <p style="text-align: center; color: #666; margin-bottom: 30px;">
                Isi data di bawah ini untuk mendapatkan rekomendasi makanan yang sesuai
            </p>
            
            <form method="POST" id="consultationForm">
                <div class="form-group">
                    <label class="icon-label">
                        <span>👤</span>
                        <span>Kelompok Usia</span>
                    </label>
                    <div class="radio-group">
                        <label class="radio-item">
                            <input type="radio" name="ageGroup" value="remaja" required>
                            <span>Remaja (11-19 tahun)</span>
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="ageGroup" value="dewasa" required>
                            <span>Dewasa (20-59 tahun)</span>
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="ageGroup" value="lansia" required>
                            <span>Lansia (60+ tahun)</span>
                        </label>
                    </div>
                    <p class="note">*Sistem ini tidak direkomendasikan untuk anak usia 0-10 tahun</p>
                </div>
                
                <div class="form-group">
                    <label class="icon-label">
                        <span>⚡</span>
                        <span>Tingkat Aktivitas Fisik</span>
                    </label>
                    <div class="radio-group">
                        <label class="radio-item">
                            <input type="radio" name="activityLevel" value="ringan" required>
                            <span>Ringan (aktivitas harian minimal, kebanyakan duduk)</span>
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="activityLevel" value="sedang" required>
                            <span>Sedang (olahraga 3-5x seminggu, aktivitas cukup)</span>
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="activityLevel" value="tinggi" required>
                            <span>Tinggi (olahraga intensif setiap hari, pekerjaan fisik berat)</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="icon-label">
                        <span>❤</span>
                        <span>Kondisi Kesehatan</span>
                    </label>
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" name="healthConditions[]" value="diabetes">
                            <span>Diabetes</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="healthConditions[]" value="hipertensi">
                            <span>Hipertensi</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="healthConditions[]" value="kolesterol">
                            <span>Kolesterol Tinggi</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="healthConditions[]" value="asam-urat">
                            <span>Asam Urat</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="healthConditions[]" value="maag">
                            <span>Maag/GERD</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="healthConditions[]" value="sehat">
                            <span>Tidak Ada</span>
                        </label>
                    </div>
                </div>
                
                <button type="submit" name="submit" class="btn">
                    Dapatkan Rekomendasi
                </button>
            </form>
        </div>
        
        <?php else: ?>
        <?php 
        $result = $_SESSION['recommendations'];
        $formData = $_SESSION['formData'];
        
        $ageLabels = [
            'remaja' => 'Remaja',
            'dewasa' => 'Dewasa',
            'lansia' => 'Lansia'
        ];
        
        $activityLabels = [
            'ringan' => 'Ringan',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi'
        ];

        // Mapping nilai kondisi kesehatan ke label yang lebih rapi untuk tampilan
        $healthConditionLabels = [
            'diabetes' => 'Diabetes',
            'hipertensi' => 'Hipertensi',
            'kolesterol' => 'Kolesterol Tinggi',
            'asam-urat' => 'Asam Urat',
            'maag' => 'Maag/GERD',
            // 'alergi' telah dihapus dari mapping
            'sehat' => 'Tidak Ada Kondisi'
        ];
        ?>
        
        <div class="result-header">
            <h2>Hasil Rekomendasi</h2>
            <div class="badges">
                <span class="badge">
                    👤 <?php echo $ageLabels[$formData['ageGroup']]; ?>
                </span>
                <span class="badge">
                    ⚡ Aktivitas <?php echo $activityLabels[$formData['activityLevel']]; ?>
                </span>
                
                <?php foreach ($formData['healthConditions'] as $condition): ?>
                    <?php if ($condition !== 'sehat' || count($formData['healthConditions']) === 1): ?>
                        <span class="badge" style="background: #e6e6fa; color: #4a148c; border: 1px solid #7e57c2;">
                            ❤ <?php echo htmlspecialchars($healthConditionLabels[$condition] ?? ucfirst($condition)); ?>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
                
            </div>
        </div>
        
        <div class="grid-2">
            <div class="card">
                <div class="card-header bg-success">
                    ✓ Makanan Direkomendasikan
                </div>
                <ul class="list">
                    <?php foreach ($result['recommended'] as $food): ?>
                    <li>
                        <span class="icon">🍽</span>
                        <span><?php echo htmlspecialchars($food); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="card">
                <div class="card-header bg-danger">
                    ✕ Makanan yang Harus Dihindari
                </div>
                <?php if (count($result['avoid']) > 0): ?>
                <ul class="list">
                    <?php foreach ($result['avoid'] as $food): ?>
                    <li>
                        <span class="icon">✕</span>
                        <span><?php echo htmlspecialchars($food); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p style="color: #666;">Tidak ada pantangan khusus</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-warning">
                ℹ Tips Nutrisi & Porsi Makan
            </div>
            <div style="margin-bottom: 20px;">
                <h4 style="margin-bottom: 10px;">Porsi Makan:</h4>
                <p style="color: #666;"><?php echo htmlspecialchars($result['portions']); ?></p>
            </div>
            <?php if (count($result['tips']) > 0): ?>
            <div>
                <h4 style="margin-bottom: 10px;">Tips Tambahan:</h4>
                <ul class="list">
                    <?php foreach ($result['tips'] as $tip): ?>
                    <li>
                        <span class="icon">✓</span>
                        <span><?php echo htmlspecialchars($tip); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <div class="card-header bg-success">
                🍽 Contoh Menu Harian
            </div>
            <div class="meal-grid">
                <div class="meal-section">
                    <h4>☀ Sarapan</h4>
                    <ul>
                        <?php foreach ($result['meals']['breakfast'] as $meal): ?>
                        <li><?php echo htmlspecialchars($meal); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="meal-section">
                    <h4>🌤 Makan Siang</h4>
                    <ul>
                        <?php foreach ($result['meals']['lunch'] as $meal): ?>
                        <li><?php echo htmlspecialchars($meal); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="meal-section">
                    <h4>🌙 Makan Malam</h4>
                    <ul>
                        <?php foreach ($result['meals']['dinner'] as $meal): ?>
                        <li><?php echo htmlspecialchars($meal); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="meal-section">
                    <h4>🍪 Cemilan Sehat</h4>
                    <ul>
                        <?php foreach ($result['meals']['snacks'] as $snack): ?>
                        <li><?php echo htmlspecialchars($snack); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <div style="text-align: center;">
            <a href="?reset=1">
                <button class="btn btn-secondary">
                    🔄 Konsultasi Lagi
                </button>
            </a>
        </div>
        
        <div class="disclaimer">
            <strong>Disclaimer:</strong> Rekomendasi ini bersifat umum dan tidak menggantikan konsultasi dengan ahli gizi atau dokter. 
            Untuk kondisi kesehatan spesifik, silakan berkonsultasi dengan profesional kesehatan.
        </div>
        
        <?php endif; ?>
    </div>
    
    <script>
        // Form validation
        document.getElementById('consultationForm')?.addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="healthConditions[]"]');
            const checked = Array.from(checkboxes).some(cb => cb.checked);
            
            if (!checked) {
                e.preventDefault();
                alert('Mohon pilih minimal satu kondisi kesehatan');
            }
        });
    </script>
</body>
</html>