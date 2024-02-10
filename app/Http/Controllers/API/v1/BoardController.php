<?php

namespace App\Http\Controllers\api\v1;

use App\Models\User;
use App\Models\Board;
use App\Models\ForumTopic;
use App\Models\ForumBoardMember;
use Illuminate\Http\Request;
use App\Models\TopicComments;
use App\Services\ForumBoardService;
use App\Http\Controllers\Controller;
use App\Models\ForumBoardActivities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ForumBoardResource;
use App\Http\Controllers\API\v1\BaseController;
use Carbon\Carbon;

class BoardController extends BaseController
{
    public function __construct(User $user)
    {
        return $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $board = Board::paginate($perPage);
            ForumBoardResource::collection($board);
            if (!empty($board)) {
                return $this->sendResponse($board, 'Board retrieved successfully.', 200);
            } else {
                return $this->sendError('Board not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function forumBoardNameList(Request $request)
    {
        try {
            $board = Board::select('id', 'board_name')->get();
            ForumBoardResource::collection($board);
            if (!empty($board)) {
                return $this->sendResponse($board, 'Board listed successfully.', 200);
            } else {
                return $this->sendError('Board not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'board_name' => 'required',
                'url' => 'required',
                'discription' => 'required',
                'members' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png|max:2048'
            ], [
                'user_id.required' => 'Please enter the user id',
                'board_name.required' => 'Please enter the board name',
                'url.required' => 'Please enter the url',
                'discription.required' => 'Please enter the description',
                'members.required' => 'Please enter member',
                'image.required' => 'Please enter image',
            ]);

            if ($validator->fails()) {
                if ($request->is('api/*')) {
                    return response()->json(
                        [
                            'status' => 402,
                            'statusState' => 'error',
                            'message' => (empty($validator->errors()) ? 'Something went wrong' : $validator->errors())->first(),
                        ],
                        402
                    );
                } else {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
            }

            $board = ForumBoardService::createUpdate(new Board, $request);
            $forum_board = new ForumBoardResource($board);
            return $this->sendResponse($forum_board, 'Board Created Successfully.', 200);
        } catch (\Exception $e) {
            return $this->sendError('Error.', ['error' => $e->getMessage()], 402);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $board = Board::find($id);
            if (!empty($board)) {
                $forum_board = new ForumBoardResource($board);
                return $this->sendResponse($forum_board, 'Board fetched successfully.', 200);
            } else {
                return $this->sendError('Board not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'board_name' => 'required',
                'url' => 'required',
                'discription' => 'required',
                'members' => 'required',
                'image' => 'mimes:jpeg, jpg, png|max:2048,'
            ], [
                'board_name.required' => 'Please enter the board name',
                'url.required' => 'Please enter the url',
                'discription.required' => 'Please enter the description',
                'members.required' => 'Please enter member'
            ]);
            if ($validator->fails()) {
                if ($request->is('api/*')) {
                    return response()->json(
                        [
                            'status' => 402,
                            'statusState' => 'error',
                            'message' => (empty($validator->errors()) ? 'Something went wrong' : $validator->errors())->first(),
                        ],
                        402
                    );
                } else {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
            }
            $board = Board::find($id);
            if (!empty($board)) {
                $board = ForumBoardService::createUpdate($board, $request);
                $forum_board = new ForumBoardResource($board);
                return $this->sendResponse($board, 'Board update successfully.', 200);
            } else {
                return $this->sendError('Invalid Board ID provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $board = Board::find($id);
            if (!empty($board)) {
                ForumBoardMember::where(['forum_board_id' => $board->id])->delete();
                $board->delete();
                return $this->sendResponse([], 'Board delete Successfully.', 200);
            } else {
                return $this->sendError('Invalid Board id provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function followBoard(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                // 'user_id' => 'required',
                'board_id' => 'required',
            ], [
                // 'user_id.required' => 'Please enter user id',
                'board_id.required' => 'Please enter board id',
            ]);

            if ($validator->fails()) {
                if ($request->is('api/*')) {
                    return response()->json(
                        [
                            'status' => 402,
                            'statusState' => 'error',
                            'message' => (empty($validator->errors()) ? 'Something went wrong' : $validator->errors())->first(),
                        ],
                        402
                    );
                } else {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
            }

            $board = Board::find($request->board_id);

            if (!empty($board)) {
                $user = Auth::user();
                $authUserId = Auth::user()->id;

                if (ForumBoardActivities::where(['user_id' => $authUserId, 'forum_board_id' => $request->board_id])->whereNull('topic_id')->count() == 0) {
                    $user = Auth::user();
                    $input['user_id'] = $authUserId;
                    $input['forum_board_id'] = $request->board_id;
                    $follower = ForumBoardActivities::create($input);

                    $res_data['user'] = $user->toArray();
                    unset($res_data['user']['token']);
                    $res_data['board'] = $board->toArray();
                    $msg = "Board Followed successfully.";
                } else {
                    $res_data['user'] = $user->toArray();
                    unset($res_data['user']['token']);
                    $res_data['board'] = $board;
                    $msg = 'You already follow this Board.';
                }
                return $this->sendResponse($res_data, $msg, 200);
            } else {
                return $this->sendError('Invalid Board ID provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function unfollowBoard(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                // 'user_id' => 'required',
                'board_id' => 'required',
            ], [
                // 'user_id.required' => 'Please enter user id',
                'board_id.required' => 'Please enter board id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 402,
                    'statusState' => 'error',
                    'message' => $validator->errors()->first(),
                ], 402);
            }

            $board = Board::find($request->board_id);

            if (!empty($board)) {
                $user = Auth::user();
                $authUserId = Auth::user()->id;

                // Unfollow the board by deleting the corresponding record
                ForumBoardActivities::where(['user_id' => $authUserId, 'forum_board_id' => $request->board_id])->whereNull('topic_id')->delete();

                $res_data['user'] = $user->toArray();
                unset($res_data['user']['token']);
                $res_data['board'] = $board->toArray();
                $msg = "Board Unfollowed successfully.";

                return response()->json([
                    'status' => 200,
                    'statusState' => 'success',
                    'data' => $res_data,
                    'message' => $msg,
                ], 200);
            } else {
                return response()->json([
                    'status' => 402,
                    'statusState' => 'error',
                    'message' => 'Invalid Board ID provided',
                ], 402);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 402,
                'statusState' => 'error',
                'message' => 'Error: ' . $th->getMessage(),
            ], 402);
        }
    }

    public function unfollowTopic(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                // 'user_id' => 'required',
                'topic_id' => 'required',
            ], [
                // 'user_id.required' => 'Please enter user id',
                'topic_id.required' => 'Please enter topic id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 402,
                    'statusState' => 'error',
                    'message' => $validator->errors()->first(),
                ], 402);
            }

            $topic = ForumTopic::find($request->topic_id);

            if (!empty($topic)) {
                $user = Auth::user();
                $authUserId = Auth::user()->id;

                // Unfollow the board by deleting the corresponding record
                ForumBoardActivities::where(['user_id' => $authUserId, 'topic_id' => $request->topic_id])->whereNull('forum_board_id')->delete();

                $res_data['user'] = $user->toArray();
                $res_data['topic'] = $topic->toArray();
                $msg = "Topic Unfollowed successfully.";

                return response()->json([
                    'status' => 200,
                    'statusState' => 'success',
                    'data' => $res_data,
                    'message' => $msg,
                ], 200);
            } else {
                return response()->json([
                    'status' => 402,
                    'statusState' => 'error',
                    'message' => 'Invalid Topic ID provided',
                ], 402);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 402,
                'statusState' => 'error',
                'message' => 'Error: ' . $th->getMessage(),
            ], 402);
        }
    }

    public function followTopic(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'topic_id' => 'required',
            ], [
                'user_id.required' => 'Please enter user id',
                'topic_id.required' => 'Please enter topic id',
            ]);

            if ($validator->fails()) {
                if ($request->is('api/*')) {
                    return response()->json(
                        [
                            'status' => 402,
                            'statusState' => 'error',
                            'message' => (empty($validator->errors()) ? 'Something went wrong' : $validator->errors())->first(),
                        ],
                        402
                    );
                } else {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
            }

            $topic = ForumTopic::find($request->topic_id);

            if (!empty($topic)) {

                $topic['attachment_urls'] = $topic->attachments->pluck('attachment')->map(function ($attachment) {
                    return asset('storage/forum_topic/' . $attachment);
                })->toArray();
                unset($topic['attachments']);

                if (ForumBoardActivities::where(['user_id' => $request->user_id, 'topic_id' => $request->topic_id])->whereNull('topic_id')->count() == 0) {
                    $user = Auth::user();
                    $input['user_id'] = $request->user_id;
                    $input['topic_id'] = (int)$request->topic_id;
                    $follower = ForumBoardActivities::create($input);

                    $res_data['topic'] = $topic->toArray();
                    $res_data['user'] = $user->toArray();
                    $msg = 'Topic Followed successfully.';
                } else {
                    $res_data = [];
                    $msg = 'You already follow this topic.';
                }
                return $this->sendResponse($res_data, $msg, 200);
            } else {
                return $this->sendError('Invalid topic id provided.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function forumBoardtopic(Request $request, $id = null)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $filter = $request->has('short_by') ? $request->has('short_by') : '';
            $searchTerm = $request->has('keyword') ? $request->query('keyword') : '';

            $query = ForumTopic::query()
            ->with([
                'user' => function ($subquery) {
                    $subquery->select('id', 'name', 'username', 'email', 'created_at');
                }
            ]);
            if (!empty($id)) {
                $query->where('forum_board_id', $id);
            }
            if (!empty($searchTerm)) {
                $query->where(function ($subquery) use ($searchTerm) {
                    $subquery->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%');
                });
            }
            if (!empty($filter) && $filter == 'latest') {
                $query->orderBy('id', 'desc');
            }
            if (!empty($filter) && $filter == 'popular') {
                $query->orderBy('topic_views', 'desc');
            }
            $topicList = $query->paginate($perPage);

            if (!empty($topicList)) {
                foreach ($topicList as $key => $value) {
                    $topicList[$key]['topic_comment'] = TopicComments::where('topicommentable_id', $value['id'])->where('commented_by', Auth::user()->id)->count();
                    $topicList[$key]['since'] = $value->created_at->format('d M, Y');
                    $topicList[$key]['attachment_urls'] = $value->attachments->pluck('attachment')->map(function ($attachment) {
                        return asset('storage/forum_topic/' . $attachment);
                    })->toArray();
                    unset($topicList[$key]['attachments']);
                }
                return $this->sendResponse($topicList, 'Forum Board Topic fetched successfully.', 200);
            } else {
                return $this->sendError('Forum Board not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }
}
