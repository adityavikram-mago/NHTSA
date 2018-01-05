<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model {

    protected $primaryKey = 'VehicleId';

    protected $fillable = [
        'VehiclePicture', 'OverallRating', 'OverallSideCrashRating',
        'FrontCrashDriversideRating', 'FrontCrashPassengersideRating', 'FrontCrashPicture', 'FrontCrashVideo',
        'SideCrashDriversideRating', 'SideCrashPassengersideRating',
        'SideCrashPassengersideNotes', 'SideCrashPicture', 'SideCrashVideo',
        'SidePoleCrashRating', 'SidePoleVideo', 'SidePolePicture',
        'RolloverRating', 'RolloverRating2', 'RolloverPossibility', 'RolloverPossibility2',
        'NHTSAElectronicStabilityControl', 'NHTSAForwardCollisionWarning', 'NHTSALaneDepartureWarning',
        'ComplaintsCount', 'RecallsCount', 'InvestigationCount',
        'VehicleId', 'VehicleDescription', 'Model', 'Make', 'ModelYear',
    ];

    public function getCrashRatingAttribute() {
        return $this->OverallRating;
    }
}
