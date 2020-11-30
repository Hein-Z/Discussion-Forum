<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionComment;
use App\Models\QuestionLike;

use App\Models\QuestionSave;
use App\Models\QuestionTag;
use App\Models\Tag;
use App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Traits\Question as QuestionTrait;


class QuestionController extends Controller
{
    use QuestionTrait;

    public function home(Request $request)
    {
        $type = $request->type;
        if ($type === 'answered') {

            $questions = Question::whereHas('comments', function (Builder $query) {
                $query->where('user_id', Auth::user()->id);
            })->with('comments', 'tags', 'saves', 'user')->paginate(10);

        } else if ($type === 'unanswered') {

            $questions = Question::has('comments', '<', 1)->with('comments', 'tags', 'saves', 'user')->paginate(10);

        } else if ($type === 'saved') {

            $questions = Question::whereHas('tags', function (Builder $query) {
                $query->where('user_id', Auth::user()->id);
            })->with('comments', 'tags', 'saves', 'user')->paginate(10);

        } else if ($slug = $request->tag) {

            $tag = Tag::where('slug', $slug)->first();
            $questions = $tag->questions()->with('comments', 'tags', 'saves', 'user')->paginate(2);

        } else {

            $questions = Question::with('comments', 'tags', 'saves', 'user')->paginate(2);

        }
        foreach ($questions as $k => $v) {
            $questions[$k]->is_like = $this->likeDetail($v->id)['is_like'];
            $questions[$k]->like_count = $this->likeDetail($v->id)['like_count'];
            $questions[$k]->is_save = $this->isSave($v->id)['is_save'];
        }
        return Inertia::render('Home.vue', ['questions' => $questions]);
    }

    ##like
    public function like($id)
    {
        QuestionLike::create([
            'user_id' => Auth::user()->id,
            'question_id' => $id
        ]);
        return response()->json(['success' => true, 'like' => 'You just like a question']);
    }

    ##unlike
    public function unlike($id)
    {
        QuestionLike::where('question_id', $id)
            ->where('user_id', Auth::user()->id)->delete();
        return response()->json(['success' => true, 'unlike' => 'You just unlike a question']);
    }

    ##question detail
    public function detail($slug, $id)
    {
        $qry = Question::where('id', $id);
        if ($qry->first()) {
            $question = $qry->with('comments.user', 'tags', 'saves', 'user')->first();
            $question->is_like = $this->likeDetail($question->id)['is_like'];
            $question->like_count = $this->likeDetail($question->id)['like_count'];
            $question->is_save = $this->isSave($question->id)['is_save'];
            return Inertia::render('QuestionDetail.vue', ['question' => $question]);
        }
        return redirect()->route('home');
    }

    ##question delete
    public function delete($id)
    {
        $delete = Question::where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    ##question save
    public function save($id)
    {

        QuestionSave::create([
            'user_id' => Auth::user()->id,
            'question_id' => $id
        ]);
        return response()->json(['success' => true]);
    }

    ##question save
    public function unsave($id)
    {

        QuestionSave::where('question_id', $id)
            ->where('user_id', Auth::user()->id)->delete();
        return response()->json(['success' => true]);
    }

    ##question fix
    public function questionFix(Request $request)
    {
        Question::where('id', $request->id)->update([
            'isFixed' => 'true'
        ]);
        return response()->json(['success' => true]);
    }

    ##question unfix
    public function questionUnfix(Request $request)
    {
        Question::where('id', $request->id)->update([
            'isFixed' => 'false'
        ]);
        return response()->json(['success' => true]);
    }

    ##comment
    public function createComment(Request $request)
    {
        ##validate
        $request->validate([
            'comment' => 'required',
            'question_id' => 'required',
        ]);

        $comment = $request->comment;
        $question_id = $request->question_id;

        $cmt = QuestionComment::create([
            'question_id' => $question_id,
            'comment' => $comment,
            'user_id' => Auth::user()->id
        ]);
        $createdComment = QuestionComment::where('id', $cmt->id)->with('user')->first();
        return ['success' => true, 'comment' => $createdComment];
    }

    ##create question
    public function createQuestion()
    {
        return Inertia::render('CreateQuestion.vue');
    }

    public function storeQuestion(Request $request)
    {
        ##validate
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $question = Question::create([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
        ]);

        if ($request->tags) {
            $tags = explode(",", $request->tags);
            foreach ($tags as $tag) {
                QuestionTag::create([
                    'question_id' => $question->id,
                    'tag_id' => $tag
                ]);
            }
        }
        return redirect()->route('question.detail', [Str::slug($request->title), $question->id]);
    }

##user question
    public function userQuestion()
    {
        $user_id = Auth::user()->id;
        $questions = Question::where('user_id', $user_id)->paginate(2);
        return Inertia::render('UserQuestion.vue', ['questions' => $questions]);
    }
}
