<?php

namespace App\Http\Controllers;

use App\Idea;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilterController extends Controller
{
    public function getAllUserName()
    {
        $users = User::orderBy('first_name')->get();
        $name = [];

        foreach ($users as $user) {
            $obj['uuid'] = $user->id;
            $obj['name'] = $user->full_name;

            array_push($name, $obj);
        }

        return response()->json(['users' => $name]);
    }

    public function filterAllIdea(Request $data)
    {

        $featuredIdeas = [];
        if ($data->topic == 'all-idea' || $data->uuid == 'all-idea') {
            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->get();
        } else if ($data->start != null && $data->end != null && $data->topic != '' && $data->uuid != '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->whereBetween('submitted_at', [$from, $to])
                ->where('topic', $data->topic)
                ->where('user_id', $data->uuid)
                ->get();
        } //3
        else if ($data->start != null && $data->end != null && $data->topic == '' && $data->uuid != '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->whereBetween('submitted_at', [$from, $to])
                ->where('user_id', $data->uuid)
                ->get();
        } //date&name
        else if ($data->start != null && $data->end != null && $data->topic != '' && $data->uuid == '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->whereBetween('submitted_at', [$from, $to])
                ->where('topic', $data->topic)
                ->get();
        } //date&topic
        else if ($data->start == null && $data->end == null && $data->topic != '' && $data->uuid != '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->where('topic', $data->topic)
                ->where('user_id', $data->uuid)
                ->get();
        } //topic&name
        else if ($data->start != null && $data->end != null && $data->topic == '' && $data->uuid == '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->whereBetween('submitted_at', [$from, $to])
                ->get();
        } //only date
        else if ($data->start == null && $data->end == null && $data->topic != '' && $data->uuid == '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->where('topic', $data->topic)
                ->get();
        } //only topic
        else if ($data->start == null && $data->end == null && $data->topic == '' && $data->uuid != '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsSubmitted(1)
                ->where('user_id', $data->uuid)
                ->get();
        } //only name

        return response()->json(['ideas' => $featuredIdeas,'ideasCount'=>count($featuredIdeas)]);
    }

    public function filterAllFeaturedIdea(Request $data)
    {

        $featuredIdeas = [];
        if ($data->start != null && $data->end != null && $data->topic != '' && $data->uuid != '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsActive(1)
                ->whereIsSubmitted(1)
                // ->whereIsApproved(1)
                ->whereIsFeatured(1)
                ->whereBetween('submitted_at', [$from, $to])
                ->where('topic', $data->topic)
                ->where('user_id', $data->uuid)
                ->get();
        } //3
        else if ($data->start != null && $data->end != null && $data->topic == '' && $data->uuid != '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsActive(1)
                ->whereIsSubmitted(1)
                // ->whereIsApproved(1)
                ->whereIsFeatured(1)
                ->whereBetween('submitted_at', [$from, $to])
                ->where('user_id', $data->uuid)
                ->get();
        } //date&name
        else if ($data->start != null && $data->end != null && $data->topic != '' && $data->uuid == '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsActive(1)
                ->whereIsSubmitted(1)
                // ->whereIsApproved(1)
                ->whereIsFeatured(1)
                ->whereBetween('submitted_at', [$from, $to])
                ->where('topic', $data->topic)
                ->get();
        } //date&topic
        else if ($data->start == null && $data->end == null && $data->topic != '' && $data->uuid != '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsActive(1)
                ->whereIsSubmitted(1)
                // ->whereIsApproved(1)
                ->whereIsFeatured(1)
                ->where('topic', $data->topic)
                ->where('user_id', $data->uuid)
                ->get();
        } //topic&name
        else if ($data->start != null && $data->end != null && $data->topic == '' && $data->uuid == '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsActive(1)
                ->whereIsSubmitted(1)
                // ->whereIsApproved(1)
                ->whereIsFeatured(1)
                ->whereBetween('submitted_at', [$from, $to])
                ->get();
        } //only date
        else if ($data->start == null && $data->end == null && $data->topic != '' && $data->uuid == '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsActive(1)
                ->whereIsSubmitted(1)
                // ->whereIsApproved(1)
                ->whereIsFeatured(1)
                ->where('topic', $data->topic)
                ->get();
        } //only topic
        else if ($data->start == null && $data->end == null && $data->topic == '' && $data->uuid != '') {
            $from = date('Y-m-d', strtotime($data->start));
            $to = date('Y-m-d', strtotime($data->end));
            // return response()->json(['ideas' => [$from, date('Y-m-d', strtotime($data->end))]]);

            $featuredIdeas = Idea::with(
                'user',
                'comments',
                'likes',
                'short_listed_idea'
            )->orderByDesc('submitted_at')
                ->whereIsActive(1)
                ->whereIsSubmitted(1)
                // ->whereIsApproved(1)
                ->whereIsFeatured(1)
                ->where('user_id', $data->uuid)
                ->get();
        } //only name

        return response()->json(['ideas' => $featuredIdeas,'ideasCount'=>count($featuredIdeas)]);
    }
}