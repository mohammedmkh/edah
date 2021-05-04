<?php

namespace App\Http\Controllers;

use App\Language;
use App\Question;
use App\QuestionLang;
use App\Cities;
use App\GroceryShop;
use App\GroceryItem;
use App\Order;
use App\QuestionOptionLang;
use App\QuestionsOption;
use Illuminate\Http\Request;
use \Validator;
use DataTables;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Question::orderBy('id', 'DESC')->paginate(7);
        // dd('QuestionQuestion');

        return view('admin.question.viewQuestion', ['questions' => $data]);
    }

    public function questionList(Request $request)
    {

        if ($request->ajax()) {
            $data = $request->all();

            $query = Question::query()->orderBy('id', 'DESC');

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });


            $table->addColumn('actions', function ($row) {
                return ' <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="' . url(adminPath() . 'Question/' . $row->id . '/edit') . '">' . __('Edit') . '</a>
                                                    <a class="dropdown-item" onclick="deleteData(`Question`,' . $row->id . ');" href="#">' . __('Delete') . '</a>

                                                </div>
                                            </div>
';
            });

            $table->rawColumns(['actions', 'image']);
            return $table->make(true);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


        return view('admin.question.addQuestion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $data = $request->all();


        $question_no_langs = Question::create($data);
        $this->addUpdateTranslation($question_no_langs, $data);

        // dd($question_no_langs);
        toastr()->success(__('Successfully completed'));

        return redirect(adminPath() . 'Question');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\GroceryQuestion $groceryQuestion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\GroceryQuestion $groceryQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Question::findOrFail($id);
        return view('admin.question..editQuestion', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\GroceryQuestion $groceryQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($id);
        $request->validate([
            'name.*' => 'bail|required|unique:question_langs,name,' . $id . ',question_id',
            'status' => 'bail|required',
        ]);
        $data = $request->all();
        $question = Question::findOrFail($id);
        // dd('unlink ooo' , $question);

        $question_no_langs = $question->update($data);
        $question_no_langs = Question::find($id);
        $this->addUpdateTranslation($question_no_langs, $data);
        toastr()->success(__('Successfully completed'));

        return redirect(adminPath() . 'Question');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\GroceryQuestion $groceryQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $item = Order::where('question_id', $id)->get();
            $deleteQuestion = Question::find($id);

            if (count($item) == 0 or $deleteQuestion->parent != 0) {

                QuestionLang::where('question_id', $id)->delete();
                $deleteQuestion->delete();
                toastr()->success(__('Successfully completed'));

                return 'true';
            } else {
                toastr()->error(__('The operation has failed'), __('Inconceivable!'));

                return response('Data is Connected with other Data', 400);
            }
        } catch (\Exception $e) {
            toastr()->error(__('The operation has failed'), __('Inconceivable!'));

            return response('Data is Connected with other Data', 400);
        }
    }


    public function addUpdateTranslation($question, $data)
    {

        foreach ($data['name'] as $key => $valueName) {
            $question_lang = QuestionLang::where('lang_id', $key)->where('question_id', $question->id)->first();
            if (!$question_lang) $question_lang = new QuestionLang;
            $question_lang->name = $valueName;
            $question_lang->lang_id = $key;
            $question_lang->question_id = $question->id;
            $questionOption_no_langs = QuestionsOption::create(['question_id' => $question->id]);

            $question_lang->save();
            foreach ($data['option'] as $key => $value) {
                if ($value != null) {                // check if data is exist or  not
                    $QuestionOptionLang = QuestionOptionLang::where('lang_id', $question_lang->lang_id)->where('questions_options_id', $questionOption_no_langs->id)->first();
                    if (!$QuestionOptionLang) $QuestionOptionLang = new QuestionOptionLang;
                    $QuestionOptionLang->name = $value;
                    $QuestionOptionLang->lang_id = $question_lang->lang_id;
                    $QuestionOptionLang->questions_options_id = $questionOption_no_langs->id;
                    $QuestionOptionLang->save();

                }
            }

        }
    }

}
