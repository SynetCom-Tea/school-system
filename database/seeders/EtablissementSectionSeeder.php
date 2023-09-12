<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtablissementSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('etablissement_section')->delete();
        
        \DB::table('etablissement_section')->insert(array (
            0 => 
            array (
                'etablissement_id' => 1,
                'section_id' => 1,
            ),
            1 => 
            array (
                'etablissement_id' => 1,
                'section_id' => 2,
            ),
            2 => 
            array (
                'etablissement_id' => 1,
                'section_id' => 3,
            ),
        ));

        INSERT INTO `etablissement_section` (`id`, `code`, `etablissement_id`, `section_id`) VALUES
(1, NULL, 1, 3),
(2, NULL, 2, 3),
(3, NULL, 3, 3),
(4, NULL, 4, 3),
(5, NULL, 5, 3),
(6, NULL, 6, 3),
(7, NULL, 7, 3),
(8, NULL, 8, 3),
(9, NULL, 9, 3),
(10, NULL, 10, 3),
(11, NULL, 11, 3),
(12, NULL, 12, 3),
(13, NULL, 13, 2),
(14, NULL, 14, 3),
(15, NULL, 15, 1),
(16, NULL, 15, 2),
(17, NULL, 16, 2),
(31, NULL, 17, 1),
(32, NULL, 17, 2);

//les users
INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `email_verified_at`, `password`, `etablissement_id`, `etablissement_section_id`, `user_id`, `apprenant_id`, `enseignant_id`, `tuteur_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Tondi', 'Bouli', 'super-admin@gmail.com', NULL, '$2y$10$nsV952/yq2B0mfBeGCmcNOziF05QraI.t8RV.mvxUWE3eTb4sxEsq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-06 11:04:01', '2023-09-06 11:04:01'),
(2, 'Abdoulaye', 'Sofiani', 'abdoul@gmail.com', NULL, '$2y$10$TTv33EuSjKMkwkISHGbwsOwnkeBl2cVWvVZ8rB71sDgfVF1RN2c6q', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-06 11:11:35', '2023-09-06 11:11:35'),
(3, 'Abdou', 'Moumouni', 'adminuam@gmail.com', NULL, '$2y$10$qM6nbybDvmfaUDRA25GU/eGkbgYGwI18vZEyYKZFr0UXWC1Xrhe3a', 2, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-07 13:17:13', '2023-09-07 13:17:13'),
(4, 'Idrissa', 'Moctar', 'adminiat@gmail.com', NULL, '$2y$10$O4FnnkAT0YccbpjG3u5qpuk0wSofs3tlocqfi9faQVVGixXtFibmu', 3, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-07 13:33:39', '2023-09-07 13:33:39'),
(5, 'Mahaman', 'Kabo', 'kabom@gmail.com', NULL, '$2y$10$9oXEFQpJxpApJpFSSWqo8.CwnzSzLAGNvvfbHFcfTCGAO.eKUMRfW', 4, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-07 13:43:22', '2023-09-07 13:43:22'),
(6, 'Adam', 'Issa', 'adamissa@gmail.com', NULL, '$2y$10$zXG8sLm8lScirPIkGOLTXegHHLuBuEss9m627ypJOn6FBEx8gJtjm', 5, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 08:50:01', '2023-09-08 08:50:01'),
(7, 'Soumeyla', 'Seyni', 'seynii@gmail.com', NULL, '$2y$10$ufgXTGI7GcrRsYwExyYqDuG/iZz9lOnzaeG4oXNZffzb//hyNpIlK', 6, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 08:52:42', '2023-09-08 08:52:42'),
(8, 'Abdoul-Aziz', 'Hima', 'himaa@gmail.com', NULL, '$2y$10$1.JSAgDpxZLMWUT9EqRjQ.R3GLmH6wwuq3LDuS8U6CGB6nWkSQdoC', 7, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 08:54:33', '2023-09-08 08:54:33'),
(9, 'Mahamadou', 'Maiyaki', 'maiyaki@gmail.com', NULL, '$2y$10$nR6rKDsj9AN4sBhVMfM5a.peXFO.kAdNo.PHcIFbF8/pqL1L9TiJO', 8, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 08:56:08', '2023-09-08 08:56:08'),
(10, 'Mohamed', 'Biga', 'bigaas@gmail.com', NULL, '$2y$10$bvkYV.b9NPkFdVgmjyCH5.li.MYTFXnyNrpPuTagKqR550q/bHOnG', 9, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 08:57:42', '2023-09-08 08:57:42'),
(11, 'Habou', 'Magagi', 'haboumagagi@gmail.com', NULL, '$2y$10$CvlAlptAifOgPjSdxX3l3.M1re1oncA7yGsHT02vra4vk7Nah/Y4O', 10, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 09:01:07', '2023-09-08 09:01:07'),
(12, 'Omar', 'Halidou', 'halidou@gmail.com', NULL, '$2y$10$gDB5x7rRhEbPrAlqLmGjk.WrL26.THoTGZbJTa/IJ1cPkEZV.BAc2', 11, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 09:03:01', '2023-09-08 09:03:01'),
(13, 'Ado', 'Yaou', 'adoyaou@gmail.com', NULL, '$2y$10$fFC6ot/uBY0CvCqpIsDCwuigLcIt1rl26JSCfdmnl9.7AT17YPGy6', 12, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 09:11:45', '2023-09-08 09:11:45'),
(14, 'Namata', 'Guéro', 'tchierry@gmail.com', NULL, '$2y$10$I3K2tftdbRqpw.cl8qRan.hhVDPoPcgLXgjoBSQlE.CIs5vbw26R2', 13, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 09:15:20', '2023-09-08 09:15:20'),
(15, 'Maman', 'Djibo', 'djibo@gmail.com', NULL, '$2y$10$Z/Z.A5LVME55J0Ylp/vv.u6GB8UUva0cm0mXxE1SFobjlFhWNcSie', 14, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 09:17:26', '2023-09-08 09:17:26'),
(16, 'Abdourahman', 'Saley', 'abdousaley@gmail.com', NULL, '$2y$10$ndSmD.ccbMSRVzXpz.ZNFeqySpda6D4sGgrN4w4ExZj5pIKIScPey', 15, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 09:20:00', '2023-09-08 09:20:00'),
(17, 'Hamidou', 'Diambala', 'diambala@gmail.com', NULL, '$2y$10$0UcwWSvCEErniVML/oUjQONOfVeXFMmrCm6IcjQyKukq3/tRWwOla', 16, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 09:22:18', '2023-09-08 09:22:18'),
(18, 'Fati', 'Ibrahim', 'fatima@gmail.com', NULL, '$2y$10$NzE6vyhnFDa6YkhL5RyWqeEUpSUE4jY4IU45erdx.oP4Ins3ySg.W', 17, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-08 09:24:32', '2023-09-08 09:24:32');
    }
}
