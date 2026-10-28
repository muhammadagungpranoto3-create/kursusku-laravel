# 🧪 Matriks Pengujian Sistem (Test Matrix)

**Sistem:** KursusKu Kubu Pisang City

-----

## Hasil Pengujian

|No |Skenario Pengujian                                              |Input Parameter                                      |Expected Output          |Actual Output            |Status|
|:-:|----------------------------------------------------------------|-----------------------------------------------------|-------------------------|-------------------------|:----:|
|1  |**Pendaftaran Mahasiswa (Web Dasar)**<br>1 Paket Pembelajaran   |Type: Mahasiswa (20%)<br>Kursus: WEB-01<br>Package: 1|Rp 160.000               |Rp 160.000               |✅ PASS|
|2  |**Pendaftaran Guru (PHP Dasar)**<br>1 Paket Pembelajaran        |Type: Guru (15%)<br>Kursus: PHP-01<br>Package: 1     |Rp 212.500               |Rp 212.500               |✅ PASS|
|3  |**Pendaftaran Umum (Laravel Fund.)**<br>1 Paket Pembelajaran    |Type: Umum (0%)<br>Kursus: LAR-01<br>Package: 1      |Rp 350.000               |Rp 350.000               |✅ PASS|
|4  |**Pendaftaran Mahasiswa Multiple Paket**<br>2 Paket Pembelajaran|Type: Mahasiswa (20%)<br>Kursus: WEB-01<br>Package: 2|Rp 320.000               |Rp 320.000               |✅ PASS|
|5  |**Pengisian Form Minat Belajar Kosong**                         |Interests: `[]`                                      |Belum ada minat tambahan.|Belum ada minat tambahan.|✅ PASS|

-----

## Ringkasan

|Total Skenario|Lulus|Gagal|
|:------------:|:---:|:---:|
|5             |5    |0    |


> **Keterangan:** Semua skenario pengujian kalkulasi biaya, diskon, dan penanganan input kosong bernilai **VALID (PASS)**.