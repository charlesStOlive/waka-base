<?php namespace Waka\Crsm\Updates\Seeders;

use DB;
use Seeder;
use Waka\Worder\Models\Document;

class SeedWorders extends Seeder
{
    public function run()
    {
        /**
         * IMPORT DES FICHIERS D EXEMPLES PUBLISHER DEPUIS DOSSIER CRSM
         */
        $localDisk = new \Waka\Utils\Classes\WorkDirFiles();
        $file = plugins_path('waka/crsm/updates/files/templates/lettre_entreprise_vide.docx');
        $localDisk->putFile($file, 'word/templates');
        $file = plugins_path('waka/crsm/updates/files/templates/offre_service_v5.docx');
        $localDisk->putFile($file, 'word/templates');
        $file = plugins_path('waka/crsm/updates/files/templates/lettre_contact_solution.docx');
        $localDisk->putFile($file, 'word/templates');
        $file = plugins_path('waka/crsm/updates/files/templates/lettre_entreprise_solution.docx');
        $localDisk->putFile($file, 'word/templates');

        /**
         * Création des documents
         */

        Db::table('waka_worder_documents')->truncate();
        $sql = plugins_path('waka/crsm/updates/sql/waka_worder_documents.sql');
        DB::unprepared(file_get_contents($sql));

    }

}
