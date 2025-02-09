<?php

  /**
   * 231232028 - Falmesino Abdul Hamid
   * Logistic Regression dengan Gradient Descent Regularized (L2)
   * Dataset: X (matrix fitur, ukuran m x n) dan y (label biner)
   */

  function sigmoid($z) {
    return 1 / (1 + exp(-$z));
  }

  function logisticRegressionGD($X, $y, $learning_rate = 0.01, $iterations = 1000, $lambda = 0.1) {
    $m = count($y);     // Jumlah data
    $n = count($X[0]);  // Jumlah fitur
    $theta = array_fill(0, $n, 0.0); // Inisialisasi parameter model

    for ($iter = 0; $iter < $iterations; $iter++) {
      $gradients = array_fill(0, $n, 0.0);
      // Hitung gradien untuk semua data
      for ($i = 0; $i < $m; $i++) {
        $z = 0;
        for ($j = 0; $j < $n; $j++) {
          $z += $theta[$j] * $X[$i][$j];
        }
        $h = sigmoid($z);
        $error = $h - $y[$i];
        for ($j = 0; $j < $n; $j++) {
          $gradients[$j] += $error * $X[$i][$j];
        }
      }
      // Update parameter dengan regulasi L2 (tidak meng-regularisasi bias jika ada)
      for ($j = 0; $j < $n; $j++) {
        $reg = ($j == 0) ? 0 : ($lambda / $m) * $theta[$j];
        $theta[$j] -= $learning_rate * (($gradients[$j] / $m) + $reg);
      }
    }
    return $theta;
  }

  // Contoh data (m = 4 data, n = 3 fitur; fitur pertama bisa berupa 1 untuk bias)
  $X = [
    [1, 2.5, 3.1],
    [1, 3.0, 3.8],
    [1, 2.8, 3.0],
    [1, 3.2, 3.9]
  ];
  $y = [0, 1, 0, 1];

  $theta = logisticRegressionGD($X, $y, 0.05, 2000, 0.05);
  echo "Parameter model (theta):\n";
  print_r($theta);
?>