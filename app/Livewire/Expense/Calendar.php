<?php

namespace App\Livewire\Expense;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Omnia\LivewireCalendar\LivewireCalendar;

class Calendar extends LivewireCalendar
{

    public function events(): Collection {
        // return collect();

        $expensesByDate = Expense::where('user_id', Auth::id())->get()->groupBy(function ($date) {
            return Carbon::parse($date->date)->format('Y-m-d'); // grouping by years
        });

        $events = collect();

        foreach ($expensesByDate as $date => $expense) {
            $events->push([
                'id' => $expense[0]->id,
                'title' => "RM ".$expense->sum('amount'),
                'description' => '',
                'date' => Carbon::parse($date),
            ]);
        }


        return $events;
    }

    public function onDayClick($year, $month, $day)
    {
        return redirect()->route('expense.show-by-date', [
            'date' => Carbon::createFromDate($year, $month, $day)->format('Y-m-d'),
        ]);
    }

    public function onEventClick($eventId)
    {
        // This event is triggered when an event card is clicked
        // You will be given the event id that was clicked
    }

}




