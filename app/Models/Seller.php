<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sellerCategory()
    {
        return $this->belongsTo(SellerCategory::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function insuranceOfferings()
    {
        return $this->hasMany(InsuranceOffering::class);
    }

    public function services(){
        return $this->hasMany(Service::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function sellerMenus()
    {
        return $this->hasMany(SellerMenu::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function sellerSpecialties()
    {
        return $this->hasMany(SellerSpecialization::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function governmentIssuedId()
    {
        return $this->belongsTo(File::class, 'government_issued_id');
    }

    public function businessRegistrationCertificate()
    {
        return $this->belongsTo(File::class, 'business_registration_certificate');
    }
    

    public function foodSafetyCertifications()
    {
        return $this->belongsTo(File::class, 'food_safety_certifications');
    }

    public function professionalLicense()
    {
        return $this->belongsTo(File::class, 'professional_license');
    }

    public function legalCertifications()
    {
        return $this->belongsTo(File::class, 'legal_certifications');
    }

    public function deliveryPartner()
    {
        return $this->hasOne(DeliveryPartner::class)->latest('id');
    }
}