I have three roles:
1) Admin
2) Seller
3) Buyer

For the seller role, I have many seller categories as you can see in the README.md file.

I want to use spatie role and permissions for creating roles and permissions. (add seeder for the three roles)

For the seller role, create models, migrations and seeders for all the seller registration categories. If you notice, there are some common fields in each seller category. 
I want you to keep them in users table the common fields. and make most of the fields in the table structure as optional because admin and buyer will also use users table.

For the seller category fields. create sellers table and add all sellers fields in that table along with seller category id. and make most of them optional as we have many seller cateogries using one table.
There will be only one common register api for all seller categories so include all fields in one api but make required field only for the choosen category as all fields in each seller category have different required and based on the seller category id, we will use those fields.

There will be login api, forgot password api and send otp api for each seller cateogry to verify the email.

for we don't have smtp configuration setup. so send otp in api response and add some comments to later add the email in send otp function and forgot password function.

Install the required libraries for spatie and auth (passport authentication). 

create api routes for registration and also for each category seller to allow them to post either their products, services or whatever they provide.

Also add home APIs to list 4 products from each seller category.

for the products there will be product categories.
Create api for listing products based on seller cateogry.


Seller Categories Below:

Restaurant Register Fields

Business Name
Business Email
Business Phone
Password
Confirm Password

Business Address
Country
State
City
Zip Code

(all required)
Operating Hours (Monday, start & end time)

Menu (image) or 
enter manually (many)
Cuisine Type, 
DishName,
Price
Quantity

delivery partner details
Name
Phone
Social Security Number

documentation & Licensing Details
Text Identification
Proof of Business Registration
Food safety certifications or health permits

============================

Apparel Register Fields

Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code


Fleet
Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

vehicle information
No of Vehicles
vehicle 1 details
Name
Vehicle Photos
Make
Model
Year
Mileage
Rate (Start Time, Amount, Hourly)
License Number
Registration Date
Registration Document (file)
Insurance Document (file)

============================

Automobile Sales Representative Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

professional details
Years of experience
Specialization (checkbox)
1) used card,
2) Luxury Vehicles
3) New Cars,
4) Electric Vehicles

vehicle information
No of Vehicles
vehicle 1 details
Name
Vehicle Photos
Make
Model
Year
Mileage
Rate (Start Time, Amount, Hourly)
License Number
Registration Date
Registration Document (file)
Insurance Document (file)

============================

Car Rental Marketplace Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

documentation & Licensing
Business Registration Certificate(file)

vehicle information
No of Vehicles
vehicle 1 details
Name
Vehicle Photos
Make
Model
Year
Mileage
Rate (Start Time, Amount, Hourly)
License Number
Registration Date
Registration Document (file)
Insurance Document (file)

============================

Automobile Sales Representative Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

professional details
Years of experience
Specialization (checkbox)
1) used card,
2) Luxury Vehicles
3) New Cars,
4) Electric Vehicles

vehicle information
No of Vehicles
vehicle 1 details
Name
Vehicle Photos
Make
Model
Year
Mileage
Rate (Start Time, Amount, Hourly)
License Number
Registration Date
Registration Document (file)
Insurance Document (file)

============================

Car Rental Marketplace Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

documentation & Licensing
Business Registration Certificate(file)

vehicle information
No of Vehicles
vehicle 1 details
Name
Vehicle Photos
Make
Model
Year
Mileage
Rate (Start Time, Amount, Hourly)
License Number
Registration Date
Registration Document (file)
Insurance Document (file)

============================

Car Wash Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

documentation & Licensing
Business Registration Certificate(file)

Operating Hours
(Monday, start & end time)

Pricing & Service information
Service Packages (number)
package 1 details
Name
Car Type
Service Type
Price

============================

Insurance Marketplace Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

documentation & Licensing
Business Registration Certificate(file)
Insurance License Number
Expiry Date of license

insurance offerings

insurance offering 1
Insurance Offering Name (dropdown)
Insurance Type (dropdown)
Coverage Option (checkbox)
1) Basic, 2) Standard, 3) Premium
Rate (Basic)*
Description

============================

Digital Bookstore Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

documentation & Licensing
Business Registration Certificate(file)

books details
Upload Books (csv) (exists sample)
or add manually
Book Title
Book Author
Book Price
Book Genre
Upload Book Cover (file)
Format (dropdown)
Upload Book File (file)

============================

Real Estate Brooker Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

documentation & Licensing
Business Registration Certificate(file)

property details
List Properties
Upload CSV (exists sample)
or add manually
Property Title
Property Type (dropdown)
Features (dropdown) (multiple)
Property Listing Type (radio)
1) Sale 2) Rent
Price
Address
City
Zipcode
Size
No of Bedrooms
Other Features (optional)
Upload Images (multiple)

============================

Black Clothing Lines & Accessories Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

============================

LegalShield Marketplace Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

documentation & Licensing
Business Registration Certificate(file)
Professional License (file)

service details
Service Name (dropdown)
Description Of Service
Pricing Model (radio)
1) Flat Fee 2) Hourly Rate
Price

Operating Hours
(Monday, start & end time)


============================


Barbar Beauty Salon Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

Operating Hours
(Monday, start & end time)

Menu Details
Upload Menu (file)
or enter menu manually
Service Name
Service Category (categories)
Service Description

(add more fields)
Price, Duration, Discount (optional)

============================

Personal Injury Attorney Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

legal credentials & verifications
Bar Association Number
Years of Experience

Upload Certificate
Upload legal Certifications (file)

insurance offerings

insurance offering 1
Insurance Offering Name (dropdown)
Insurance Type (dropdown)
Coverage Option (checkbox)
1) Basic, 2) Standard, 3) Premium
Rate (Basic)*
Description


============================


Mississippi Catfish Company Register Fields
Business Name
Business Email
Business Phone
Password
Confirm Password
Business Address
Country
State
City
Zip Code

verify identity
government-issued id
(driver’s license, passport etc)

Upload Menu
Upload menu (csv) (exists sample)
or add manually
What do you sell? (checkbox)
1) Fresh Catfish 2) Other Seafood
3) Packaged/Frozen
Upload Photo
Price
Quantity