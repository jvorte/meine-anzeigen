@props(['ad'])

@php
    // This logic is best placed in a Model method or a dedicated service,
    // but for this component, we'll process it here.

    // 1. Determine the correct route for the ad's detail page
    $adRouteName = 'ads.show';
    $adParamName = 'ad';
    $routeParam = $ad; // Default to passing the model for Route Model Binding

    if ($ad instanceof \App\Models\Car) {
        $adRouteName = 'categories.cars.show';
        $adParamName = 'car';
    } elseif ($ad instanceof \App\Models\Boat) {
        $adRouteName = 'categories.boats.show';
        $adParamName = 'boat';
    } elseif ($ad instanceof \App\Models\Camper) {
        $adRouteName = 'categories.campers.show';
        $adParamName = 'camper';
    } elseif ($ad instanceof \App\Models\CommercialVehicle) {
        $adRouteName = 'categories.commercial-vehicles.show';
        $adParamName = 'commercialVehicle';
    } elseif ($ad instanceof \App\Models\Electronic) {
        $adRouteName = 'categories.electronics.show';
        $adParamName = 'electronic';
    } elseif ($ad instanceof \App\Models\HouseholdItem) {
        $adRouteName = 'categories.household.show';
        $adParamName = 'householdItem';
    } elseif ($ad instanceof \App\Models\MotorradAd) {
        $adRouteName = 'categories.motorcycles.show';
        $adParamName = 'motorradAd';
    } elseif ($ad instanceof \App\Models\Other) {
        $adRouteName = 'categories.others.show';
        $adParamName = 'other';
    } elseif ($ad instanceof \App\Models\RealEstate) {
        $adRouteName = 'categories.real-estate.show';
        $adParamName = 'realEstate';
    } elseif ($ad instanceof \App\Models\Service) {
        $adRouteName = 'categories.services.show';
        $adParamName = 'service';
    } elseif ($ad instanceof \App\Models\UsedVehiclePart) {
        $adRouteName = 'categories.vehicles-parts.show';
        $adParamName = 'usedVehiclePart';
    }

    // 2. Determine the image URL
    $imageUrl = 'https://placehold.co/400x250/E0E0E0/6C6C6C?text=No+Image';
    if ($ad->images && $ad->images->isNotEmpty()) {
        $thumbnailImage = $ad->images->firstWhere('is_thumbnail', true);
        if ($thumbnailImage && $thumbnailImage->image_path) {
            $imageUrl = asset('storage/' . $thumbnailImage->image_path);
        } elseif ($ad->images->first() && $ad->images->first()->image_path) {
            $imageUrl = asset('storage/' . $ad->images->first()->image_path);
        }
    }

    // 3. Determine the