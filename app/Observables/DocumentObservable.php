<?php
namespace App\Observables;

use App;
use App\Document;
use App\Contracts\DocumentManagerContract;

/**
 * Class DocumentObservable
 * @package App\Observables
 */
class DocumentObservable
{
    /**
     * @param Document $document
     */
    public function creating(Document $document)
    {
        if (!$document->token) {
            $document->token = md5($document->title);
        }

        if (!$document->permissions) {
            $document->permissions = Document::PERMISSIONS_PUBLIC;
        }

        if (!$document->real_preview) {
            $document->preview = App::make(DocumentManagerContract::class)
                ->toPreview($document);
        }
    }
}