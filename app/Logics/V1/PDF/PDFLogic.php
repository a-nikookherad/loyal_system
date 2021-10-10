<?php


namespace App\Logics;


class PDFLogic
{

    public function __construct()
    {
    }


    public function processPDF($pdf_file, ...$args) {
        $confirmationNumber = "";
        $entrantName = "";
        $yearOfBirth = "";

        $lookupConfirmationId = "Confirmation Number:";
        $lookupEntrantName = "Entrant Name:";
        $lookupYearOfBirth = "Y ear of Birth:";

        $parser = new \Smalot\PdfParser\Parser();
        $parsedPDF = $parser->parseFile($pdf_file);

        $pages = $parsedPDF->getPages();

        $text = $pages[0]->getText();
        $explodedText = explode("\n", $text);

        for ($i = 0; $i < count( $explodedText ); $i++) {
            if(trim($explodedText[$i]) == $lookupConfirmationId) {
                $confirmationNumber = $explodedText[$i + 1];
            }

            if(trim($explodedText[$i]) == $lookupEntrantName) {
                $entrantName = $explodedText[$i + 1];
            }

            if(trim($explodedText[$i]) == $lookupYearOfBirth) {
                $yearOfBirth = $explodedText[$i + 1];
            }
        }

        return [
            $confirmationNumber,
            $entrantName,
            $yearOfBirth,
        ];
    }
}
