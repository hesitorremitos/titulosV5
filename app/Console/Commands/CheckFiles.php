<?php

namespace App\Console\Commands;

use App\Models\DiplomaAcademico;
use Illuminate\Console\Command;

class CheckFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:files';
    protected $description = 'Revisa los archivos en el directorio y actualiza los registros de DiplomaAcademico';


    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $diplomas = DiplomaAcademico::with('persona', 'mencion')->get();
        foreach ($diplomas as $diploma) {
            $filePath = 'DiplomaAcademico/'. $diploma->mencion->nombre . '/';
            # el nombre del archivo sera CI - NombresPersonas - ApellidoPaterno - ApellidoMaterno.pdf
            # Si no tiene apellido paterno o materno, se omiten
            $fileName = $diploma->persona->ci . ' - ' . $diploma->persona->nombres;
            if($diploma->persona->paterno) {
                $fileName .= ' ' . $diploma->persona->paterno;
            }
            if($diploma->persona->materno) {
                $fileName .= ' ' . $diploma->persona->materno;
            }
            $fileName = $fileName . '.pdf';

            $this->info('Verificando archivo: ' . $fileName);

            if(file_exists($filePath . $fileName)) {
                $this->info('El archivo existe');
                $diploma->update(['archivo' => $fileName]);
            } else {
                $this->error('El archivo no existe');
            }
        }
    }
}
