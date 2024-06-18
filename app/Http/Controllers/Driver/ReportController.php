<?php


namespace App\Http\Controllers\Driver;


use App\Helper\CustomController;
use App\Models\BroadcastReport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ReportController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $imagePath = '/assets/reports';
            if ($this->request->hasFile('file_speedometer')) {
                $file = $this->request->file('file_speedometer');
                $documentName = $this->upload_image($file, $imagePath);
                $data_request = [
                    'user_id' => auth()->id(),
                    'image' => $documentName,
                    'type' => 'speedometer',
                    'latitude' => 0,
                    'longitude' => 0,
                ];
                BroadcastReport::create($data_request);
            }

            if ($this->request->hasFile('file_media')) {
                $file = $this->request->file('file_media');
                $documentName = $this->upload_image($file, $imagePath);
                $data_request = [
                    'user_id' => auth()->id(),
                    'image' => $documentName,
                    'type' => 'media',
                    'latitude' => 0,
                    'longitude' => 0,
                ];
                BroadcastReport::create($data_request);
            }
            DB::commit();
            return $this->jsonSuccessResponse('success');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    private function upload_image($file, $imagePath)
    {
        $extension = $file->getClientOriginalExtension();
        $document = Uuid::uuid4()->toString() . '.' . $extension;
        $destinationPath = $this->public_path() . $imagePath;
        $documentName = $imagePath . '/' . $document;
        $file->move($destinationPath, $documentName);
        return $documentName;
    }
}
