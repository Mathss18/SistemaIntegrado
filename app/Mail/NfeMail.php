<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NfeMail extends Mailable
{
    use Queueable, SerializesModels;

    private $cliente, $nfe;

    public function __construct($nfe, $cliente)
    {

        $this->cliente = $cliente;
        $this->nfe = $nfe;
    }

    public function build()
    {
        return $this->markdown('admin.nfe.mail');
    }
    public function enviarEmailCli()
    {

        Mail::send('admin.nfe.mail', ['cliente' => $this->cliente, 'nfe' => $this->nfe], function ($m) {
            //Configurando path dos arquivos para enviar
            $path_xml = storage_path('app\public\\');
            $path_xml = storage_path('app\public\\');
            $this->nfe['path_nfe'] = str_replace("/", "\\", $this->nfe['path_nfe']);
            $this->nfe['path_nfe'] = str_replace("/", "\\", $this->nfe['path_nfe']);
            $xml = $path_xml . $this->nfe['path_nfe'] . '.xml';
            $pdf = $path_xml . $this->nfe['path_nfe'] . '.pdf';

            $m->from('flexmol@flexmol.com.br', 'Flex-Mol, Nota Fiscal Eletrônica');
            $m->attach($xml);
            $m->attach($pdf);
            $m->to($this->cliente['email'], $this->cliente['nome'])->subject('NFe chave: '.$this->nfe['chaveNF']);
        
        });
       
    }

    public function enviarEmailProprio()
    {

        Mail::send('admin.nfe.mail', ['cliente' => $this->cliente, 'nfe' => $this->nfe], function ($m) {
            //Configurando path dos arquivos para enviar os paths são absolutos
            $path_xml = storage_path('app\public\\');
            $path_xml = storage_path('app\public\\');
            $this->nfe['path_nfe'] = str_replace("/", "\\", $this->nfe['path_nfe']);
            $this->nfe['path_nfe'] = str_replace("/", "\\", $this->nfe['path_nfe']);
            $xml = $path_xml . $this->nfe['path_nfe'] . '.xml';
            $pdf = $path_xml . $this->nfe['path_nfe'] . '.pdf';

            $m->from('flexmol@flexmol.com.br', 'Flex-Mol, Nota Fiscal Eletrônica');
            $m->attach($xml);
            $m->attach($pdf);
            $m->to('flexmol@flexmol.com.br', $this->cliente['nome'])->subject('NFe chave: '.$this->nfe['chaveNF']);
        
        });
       
    }
}
