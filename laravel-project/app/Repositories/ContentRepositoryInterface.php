<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Http\Requests\ContentRequest;

interface ContentRepositoryInterface{
    public function index();
    public function registContent(Request $request);
    public function registImage(Content $content,string $food_img_name,string $shop_img_name);
    public function updateContent(ContentRequest $request);
    public function SearchContent(Request $request);
    public function detailContent(Request $request);
    public function updateTragetImage(Content $content);
    public function DeleteContent(Request $request);
    public function deleteTragetContent(Request $request);
    public function deleteContentExists(Request $request);
    public function ImageFind($img_id);
}