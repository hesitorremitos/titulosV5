<?php

namespace App\Console\Commands;

use App\Models\DiplomaAcademico;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckFiles extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'check:files {year}';
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
    $year = $this->argument('year');
    $diplomas = DiplomaAcademico::with('persona', 'mencion')->get();
    foreach ($diplomas as $diploma) {

      if ($diploma->verificado == true) {
        if (!Storage::disk('local')->exists($diploma->file_dir)) {
          $diploma->verificado = false;
          $diploma->save();
        }
      } else {
        $filePath = 'Diplomas Academicos/' . $diploma->observaciones . '/';
        # el nombre del archivo sera CI - NombresPersonas - ApellidoPaterno - ApellidoMaterno.pdf
        # Si no tiene apellido paterno o materno, se omiten
        $fileName = $diploma->persona->ci . '- ' . $diploma->persona->nombres;
        if ($diploma->persona->paterno) {
          $fileName .= ' ' . $diploma->persona->paterno;
        }
        if ($diploma->persona->materno) {
          $fileName .= ' ' . $diploma->persona->materno;
        }
        $fileName = $fileName . '.pdf';
        $this->info('Verificando archivo: ' . $filePath . $fileName);
        if (Storage::disk('local')->exists("respaldo/{$year}/" . $filePath . $fileName)) {
          $this->info('El archivo existe');

          // Mover el archivo de respaldo a la carpeta DiplomaAcademico
          Storage::disk('local')->move("respaldo/{$year}/" . $filePath . $fileName, $filePath . $fileName);
          // Actualizar el registro en la base de datos
          $diploma->file_dir = $filePath . $fileName;
          $diploma->verificado = true;
          $diploma->save();
        } else {
          $diploma->verificado = false;
          $this->error('El archivo no existe');
        }
      }
    }
  }
}
