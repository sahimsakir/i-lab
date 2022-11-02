<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;

class UploadController extends Controller
{

    public function storeUpload(Request $request)
    {
        $upload = new Upload();

        if ($request->idea_id == '') {

            $idea = new Idea();
            $idea->user_id = auth()->id();
            $idea->is_active = false;
            $idea->is_submitted = false;
        } else {
            $idea = Idea::find($request->idea_id);
        }

        $idea->topic = $request->topic ?? '';
        $idea->title = $request->title ?? '';
        $idea->elevator_pitch = $request->elevator_pitch ?? '';
        $idea->description = $request->description ?? '';
        $idea->save();

        if ($request->has('image') && !empty($idea) && $idea->user_id == auth()->id()) {
            // return $request->idea_id;
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $extenstion = '.' . $file->getClientOriginalExtension();

            $newName = str_replace($extenstion, '_' . date('Y-m-d_h-i-s') . $extenstion, $fileName);
            $file->move(public_path('idea/files/'), $newName);

            // $upload->uuid = Auth::user()->uuid;
            $upload->idea_id = $idea->id;
            $upload->title = sr(pathinfo($fileName, PATHINFO_FILENAME)) ?: 'Untitled';
            $upload->file = $newName;
            $upload->size = $request->size;

            $upload->save();
        } else {
            $upload['error'] = "Something went wrong!!";
        }
        // return response(['data' => $upload], 200);
        return  $upload;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete_uploads_files(Request $request)
    {
        $upload = Upload::where('uuid', $request->upload_id)->first();
        $idea = Idea::find($upload->idea_id);
        // return $idea;
        if ($upload->idea->user_id != auth()->id()) {
            $res['message'] = 'Whoops! Sorry, but you are not allowed to perform the action requested.';

            return redirect()->back();
        }

        // return asset('/idea/files/') . '/' . $upload->file;
        $filePath = public_path() . '/idea/files/';
        File::delete($filePath . $upload->file);

        $upload->delete();

        $res['message'] = 'Uploaded file #' . $upload->uuid . ' was deleted on ' . Carbon::now()->format('F j, Y, g:i A');

        return redirect()->route('dashboard.idea.edit', [$idea->uuid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Upload $upload): \Illuminate\Http\RedirectResponse
    {
        if ($upload->idea->user_id != auth()->id()) {
            laraflash()->message('Whoops! Sorry, but you are not allowed to perform the action requested.')->danger();

            return redirect()->back();
        }
        $filePath = public_path() . '/idea/files/';

        File::delete($filePath . $upload->file);
        $upload->delete();

        laraflash()->message('Uploaded file #' . $upload->uuid . ' was deleted on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->back();
    }
}