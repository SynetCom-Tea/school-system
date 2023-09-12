<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apprenant;

class EtablissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Etablissement::create([
            'name' => 'IAI-Niger',
            'email' => 'iainiger@gmail.com',
            'adresse' => 'Plateau',
            'telephone' => 'Mahamadou',
            'ville' => 'Mahamadou',
            'statut' => 'Mahamadou',
            'logo' => 'Mahamadou',
            'type_etablissement_id' => 'Mahamadou',
            'systeme_lmd_id' => 'Mahamadou',
            'logo' => 'Mahamadou',
        ]);

        INSERT INTO `etablissements` (`id`, `name`, `email`, `adresse`, `telephone`, `ville`,`statut`, `logo`, `type_etablissement_id`, `systeme_lmd_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'IAI-Niger', 'iainiger@gmail.com', 'Plateau', '\"20142564A\"', 'Niamey',0, 'iai-logo.jpg', 3, NULL, NULL, '2023-09-06 11:11:35', '2023-09-06 11:11:35'),
(2, 'UAM', 'uamniger@gmail.com', 'Harobanda', '\"96451232\"', 'Niamey',1, 'uam-logo.jpg', 1, NULL, NULL, '2023-09-07 13:17:12', '2023-09-07 13:17:12'),
(3, 'IAT-Niger', 'iatniger@gmail.com', 'Francophonie', '\"21047862\"', 'Niamey',0, 'iat-logo.png', 3, NULL, NULL, '2023-09-07 13:33:37', '2023-09-07 13:33:37'),
(4, 'Gamma', 'gamma@niger.com', 'Yantala', '\"21045478\"', 'Tahoua',1, 'log.png', 3, NULL, NULL, '2023-09-07 13:43:21', '2023-09-08 10:01:07'),
(5, 'Université de Maradi', 'uddm@gmail.com', 'Maradi', '\"20145698\"', 'Maradi',1, 'uddm.jpg', 1, NULL, NULL, '2023-09-08 08:49:59', '2023-09-08 08:49:59'),
(6, 'Université de Dosso', 'udoniger@gmail.com', 'Dosso', '\"21045621\"', 'Dosso',0,'udo.jpg', 1, NULL, NULL, '2023-09-08 08:52:42', '2023-09-08 08:52:42'),
(7, 'Université de Tillabéri', 'utiniger@gmail.com', 'Tillaberi', '\"21254586\"', 'Tilabéri',0, 'ut.png', 1, NULL, NULL, '2023-09-08 08:54:32', '2023-09-08 08:54:32'),
(8, 'Université de Tahoua', 'utaniger@gmail.com', 'Tahoua', '\"21478569\"', 'Tahoua',1,'uta.webp', 1, NULL, NULL, '2023-09-08 08:56:07', '2023-09-08 12:21:50'),
(9, 'Université d\'Agadez', 'uazniger@gmail.com', 'Arlit', '\"21356847\"', 'Agadez', 1,'uaz).jpg', 1, NULL, NULL, '2023-09-08 08:57:42', '2023-09-08 08:57:42'),
(10, 'Université de Zinder', 'uzniger@gmail.com', 'Zinder', '\"21235846\"', 'Zinder',1, 'uz.jpg', 1, NULL, NULL, '2023-09-08 09:01:06', '2023-09-08 09:01:06'),
(11, 'IPSP', 'ipsp@gmail.com', 'Niamey 2000', '\"21044588\"', 'Niamey', 0,'ipsp.png', 3, NULL, NULL, '2023-09-08 09:03:01', '2023-09-08 09:03:01'),
(12, 'IFTIC', 'ifticne@gmail.com', 'Plateau', '\"21258468\"', 'Niamey',1, 'iftic.png', 3, NULL, NULL, '2023-09-08 09:11:44', '2023-09-08 09:11:44'),
(13, 'Collège-Lycée Mariama', 'clmariama@gmail.com', 'Nouveau Marché', '\"20548765\"', 'Niamey', 1, 'mariama.jpg', 2, NULL, NULL, '2023-09-08 09:15:20', '2023-09-08 09:15:20'),
(14, 'INIME', 'inime@gmail.com', 'Francophonie', '\"21035647\"', 'Niamey',1, 'inime.jpg', 3, NULL, NULL, '2023-09-08 09:17:26', '2023-09-08 09:17:26'),
(15, 'CSP Lumière', 'lumiere@gmail.com', 'Kalley-Sud', '\"96541235\"', 'Niamey',0, 'lumiere.jpg', 2, NULL, NULL, '2023-09-08 09:19:59', '2023-09-08 09:19:59'),
(16, 'Lycée d\'Excellence', 'lexni@gmail.com', 'Bassora', '\"93521436\"', 'Niamey', 1,'lex.jpg', 2, NULL, NULL, '2023-09-08 09:22:18', '2023-09-08 09:22:18'),
(17, 'La Relève', 'releve@gmail.com', 'Koira Kano', '\"88521469\"', 'Niamey', 1,'releve.jpg', 2, NULL, NULL, '2023-09-08 09:24:31', '2023-09-08 12:39:21');

    }
}
