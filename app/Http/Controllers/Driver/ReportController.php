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

    public function index()
    {
        if ($this->request->method() === 'POST') {
            return $this->store();
        }
        try {
            $data = BroadcastReport::with([])
                ->where('user_id', '=', auth()->id())
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        }catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
    private function store()
    {
        try {
            $imagePath = '/assets/reports';
            $type = $this->postField('type');
            $latitude = $this->postField('latitude');
            $longitude = $this->postField('longitude');
            if ($this->request->hasFile('file')) {
                $file = $this->request->file('file');
                $documentName = $this->upload_image($file, $imagePath);
                $data_request = [
                    'user_id' => auth()->id(),
                    'image' => $documentName,
                    'type' => $type,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ];
                BroadcastReport::create($data_request);
            }
            return $this->jsonSuccessResponse('success');
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    /**
     * @param UploadedFile $file
     * @param $imagePath
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
