<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Http\Resources\CardResource;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = Card::query()
            ->get();

        return CardResource::collection(
            $cards
        );
    }

    public function listCards(Request $request)
    {
        
        validator(request()->all(), [
            'status' => [Rule::in([Card::STATUS_ACTIVE, Card::STATUS_DELETED])],
            'date' => ['date'],

        ])->validate();

        $cards = Card::query()
            ->when(
                request('date'),
                fn ($query) => $query->whereDate('created_at', request('date'))
            )->when(
                $request->has('status'),
                fn ($query) => $query->where("status", $request->status)
            )
            ->get();

        return CardResource::collection(
            $cards
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCardRequest $request)

    {
        
        $cardNew = Card::create($request->validated());

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCardRequest  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCardRequest $request, Card $card)
    {
        $cardUpdate = Card::where('id', $card->id)->firstOrFail();
        $cardUpdate->title = $request->title;
        $cardUpdate->save();
        return response()->json('Card Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }
    public function sync(Request $request)
    {


        $this->validate(request(), [
            'columns' => ['required', 'array']
        ]);
      
        foreach ($request->columns as $status) {

            
            foreach ($status['cards'] as $i => $card) {
           
                $order = $i + 1;
                if ($card['column_id'] !== $status['id'] || $card['order'] !== $order) {


                    //Here I am getting the record of Card for which location Or its column is changed
                    //then I am updating its parent column id from old to new
                    //as well changing and updating the order of card in column
                    //Gul here
                    $abc = Card::where('id', $card['id'])->first();
                    // dd($abc->title);
                    $abc->update(['column_id' => $status['id'], 'order' => $order]);
                }
            }
        }

        return Column::with('cards')->get();
    }
}
