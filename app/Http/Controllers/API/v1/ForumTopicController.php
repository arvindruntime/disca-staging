<?php

namespace App\Http\Controllers\API\v1;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Forum;
use App\Models\ForumTopic;
use Illuminate\Http\Request;
use App\Models\TopicComments;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ForumBoardActivities;
use App\Models\ForumTopicAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\v1\BaseController;
use App\Services\ForumTopicService;

class ForumTopicController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_topic()
    {
        try {
            $perPage = empty($per_page) ? 5 : $per_page;
            $forum_topic = ForumTopic::with(['user' => function ($query) {
                $query->select('id', 'name', 'username','email','created_at');
            },])
                ->withCount(['topicComments'])
                ->where('status', 1)
                ->paginate($perPage);

            foreach ($forum_topic as $key => $topic) {
                $topic->attachments_url = $topic->attachments->pluck('attachment')->map(function ($attachment) {
                    return url('forum_topic/' . $attachment);
                })->toArray();
                unset($forum_topic[$key]->attachments);
            }
            return $this->sendResponse($forum_topic, 'Topic retrieved successfully.', 200);
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_topic(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'forum_board_id' => 'required',
                'description' => 'required',
                'image' => 'required',
            ],
            [
                'title.required' => 'Please enter the title',
                'forum_board_id.required' => 'Please enter the forum board id',
                'description.required' => 'Please enter the description',
                'image.required' => 'Please enter the attachment',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 402,
                    'statusState' => 'error',
                    'message' => (empty($validator->errors())
                        ? 'Something went wrong'
                        : $validator->errors()
                    )->first(),
                ], 402);
            }

            $forum_topic = new ForumTopic();
            $forum_topic->user_id = Auth::user()->id;
            $forum_topic->forum_board_id = CheckValue($request->forum_board_id, 0);
            $forum_topic->title = CheckValue($request->title, '');
            $forum_topic->description = CheckValue($request->description, '');
            $forum_topic->status = 1;
            $forum_topic->topic_views = 0;
            $forum_topic->save();

            $attachment_ids = [];

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $key => $image) {

                    $fileName = $key . "_" . time() . '.' . $image->extension();
                    $img_path = public_path('forum_topic/');
                    UploadImage($fileName, $img_path, $request->file('image')[$key], '360');

                    $forum_topic_attachment = new ForumTopicAttachment();
                    $forum_topic_attachment->forum_topic_id = $forum_topic->id;
                    $forum_topic_attachment->attachment = $fileName;
                    $forum_topic_attachment->save();
                    $attachment_ids[] = $forum_topic_attachment->id;
                }
            }

            $attachment_urls = $forum_topic->attachments->pluck('attachment')->map(function ($attachment) {
                return url('forum_topic/' . $attachment);
            })->toArray();

            //$forum_topic->attachment_id = implode(', ', $attachment_ids);
            //$forum_topic->save();

            $response_data = [
                'id' => $forum_topic->id,
                'user_id' => $forum_topic->user_id,
                'forum_board_id' => $forum_topic->forum_board_id,
                'title' => $forum_topic->title,
                'description' => $forum_topic->description,
                'status' => $forum_topic->status,
                'topic_views' => $forum_topic->topic_views,
                'created_at' => Carbon::parse($forum_topic->created_at)->format('d M, Y'),
                'attachments' => $attachment_urls,
            ];

            if ($request->wantsJson()) {
                return $this->sendResponse($response_data, 'Topic created successfully.', 200);
            } else {
                return redirect()->route('user.home');
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Http\Response
     */
    public function show($id = "")
    {
        try {
            $ForumTopic = ForumTopic::find($id);
            if (!empty($ForumTopic)) {
                $forum_topic = ForumTopicService::view($id);
                return $this->sendResponse($forum_topic, 'Topic retrieved successfully.', 200);
            } else {
                return $this->sendError('Topic not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Http\Response
     */
    public function edit_topic(Request $request, $id)
    {
        try {
            $forum_topic = ForumTopic::with(['attachments'])->where('user_id', Auth::user()->id)->where('id', $id)->first();
            if (!empty($forum_topic)) {
                $forum_topic->attachments_url = $forum_topic->attachments->pluck('attachment')->map(function ($attachment) {
                    return url('forum_topic/' . $attachment);
                })->toArray();
                if ($request->is('api/*')) {
                    return $this->sendResponse($forum_topic, 'Topic retrieved successfully.', 200);
                } else {
                    return redirect()->route('user.home');
                }
            } else {
                return $this->sendError('Topic not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Http\Response
     */
    public function update_topic(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'forum_board_id' => 'required',
                'description' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 402,
                    'statusState' => 'error',
                    'message' => (empty($validator->errors())
                        ? 'Something went wrong'
                        : $validator->errors()
                    )->first(),
                ], 402);
            }

            $input = $request->only(['title', 'forum_board_id', 'description']);
            if (Auth::user()->user_type != 1) {
                $input['user_id'] = Auth::user()->id;
            }
            if ($request->hasFile('image')) {
                ForumTopicAttachment::where('forum_topic_id', $id)->delete();
                foreach ($request->file('image') as $key => $image) {

                    $fileName = $key . "_" . time() . '.' . $image->extension();
                    $img_path = public_path('forum_topic/');
                    UploadImage($fileName, $img_path, $request->file('image')[$key], '360');
                    
                    $forum_topic_attachment = new ForumTopicAttachment();
                    $forum_topic_attachment->forum_topic_id = $id;
                    $forum_topic_attachment->attachment = $fileName;
                    $forum_topic_attachment->save();
                    $attachment_ids[] = $forum_topic_attachment->id;
                }
            }
            ForumTopic::where('id', $id)->update($input);

            if ($request->is('api/*')) {
                return $this->sendResponse([], 'Topic updated successfully.', 200);
            } else {
                return redirect()->route('user.home');
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Http\Response
     */
    public function delete_topic($id)
    {
        try {
            if (!empty($id)) {
                $forum_topic = ForumTopic::where(['id' => $id]);
                if (!Auth::user()->user_type == 1) {
                    $forum_topic = $forum_topic->where(['user_id' => Auth::user()->id]);
                }
                $forum_topic = $forum_topic->first();
                if (!empty($forum_topic)) {
                    $attachment_list = ForumTopicAttachment::where(['forum_topic_id' => $id])->get();
                    if (!empty($attachment_list)) {
                        foreach ($attachment_list as $key => $value) {
                            if (!empty($value->attachment)) {
                                $image_path = public_path('forum_topic/' . $value->attachment);
                                DeleteImage($image_path);
                            }
                            $attachment = ForumTopicAttachment::findOrFail($value->id);
                            $attachment->delete();
                        }
                    }
                    $forum_topic->delete();

                    return $this->sendResponse([], 'Topic deleted successfully.', 200);
                } else {
                    return $this->sendError('Topic not found.', [], 402);
                }
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function followingTopicList(Request $request)
    {
        $userId = Auth::user()->id;
        $followingTopics = ForumBoardActivities::where('user_id', $userId)
            ->pluck('topic_id')
            ->toArray();
        $perPage = $request->input('per_page', 10);
        $topics = ForumTopic::with(['user'])->whereIn('id', $followingTopics)->paginate($perPage);
        $message = 'Following topic listed successfully';
        return sendResponse($topics, $message);
    }
}
