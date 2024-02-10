<?php

namespace App\Http\Resources;

use App\Models\Board;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ForumBoardMember;

class ForumBoardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {   
        $memberList = ForumBoardMember::where(['forum_board_id' => $this->id])->get();
        $total_count = count($memberList);
        return 
        [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'board_name' => $this->board_name,
            'url' => $this->url,
            'discription' => $this->discription,
            'image' => $this->image,    
            'members' => $total_count,
            'since' =>  $this->created_at->format('d M, Y'),
            'memberList' => $memberList   
        ];
    }
}
