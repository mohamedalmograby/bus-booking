<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\BookingService;

class MakeReservationRequest extends FormRequest
{
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_city_id' => 'required|integer|exists:cities,id',
            'end_city_id' => 'required|integer|exists:cities,id',
            'seat_id' => 'required|integer|exists:seats,id',
        ];
    }

    public function withValidator($validator) { // ofcourse this can be optimized but I ran out of time
        $validator->after(function ($validator) {
            $inputs = $this->all();
            
            $trips = $this->bookingService->getAvailableSeats($inputs['start_city_id'], $inputs['end_city_id']);
            $found = 0 ; 
            foreach($trips as $trip) {
                foreach($trip->buses as $bus) {
                    foreach($bus->free_seats_ids as $seatId) {
                        if($seatId == $inputs['seat_id']) {
                            $found = 1 ;
                        }
                    }
                }
            }
            if($found == 0) {
                $validator->errors()->add('seat_id', 'Seat is not available');
            }
            
        });
    }
}
