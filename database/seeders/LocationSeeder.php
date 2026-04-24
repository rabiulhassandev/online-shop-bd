<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Division::truncate();
        District::truncate();
        Upazila::truncate();

        $locations = [
            [
                'division' => ['name' => 'Barishal', 'bn_name' => 'বরিশাল'],
                'districts' => [
                    [
                        'name' => 'Barguna', 'bn_name' => 'বরগুনা',
                        'upazilas' => [
                            ['name' => 'Amtali', 'bn_name' => 'আমতলী'],
                            ['name' => 'Bamna', 'bn_name' => 'বামনা'],
                            ['name' => 'Betagi', 'bn_name' => 'বেতাগী'],
                            ['name' => 'Barguna Sadar', 'bn_name' => 'বরগুনা সদর'],
                            ['name' => 'Patharghata', 'bn_name' => 'পাথরঘাটা'],
                            ['name' => 'Taltali', 'bn_name' => 'তালতলী'],
                        ],
                    ],
                    [
                        'name' => 'Barishal', 'bn_name' => 'বরিশাল',
                        'upazilas' => [
                            ['name' => 'Agailjhara', 'bn_name' => 'আগৈলঝাড়া'],
                            ['name' => 'Babuganj', 'bn_name' => 'বাবুগঞ্জ'],
                            ['name' => 'Bakerganj', 'bn_name' => 'বাকেরগঞ্জ'],
                            ['name' => 'Banaripara', 'bn_name' => 'বানারীপাড়া'],
                            ['name' => 'Gaurnadi', 'bn_name' => 'গৌরনদী'],
                            ['name' => 'Hizla', 'bn_name' => 'হিজলা'],
                            ['name' => 'Muladi', 'bn_name' => 'মুলাদী'],
                            ['name' => 'Barishal Sadar', 'bn_name' => 'বরিশাল সদর'],
                            ['name' => 'Mehendiganj', 'bn_name' => 'মেহেদীগঞ্জ'],
                            ['name' => 'Wazirpur', 'bn_name' => 'উজিরপুর'],
                        ],
                    ],
                    [
                        'name' => 'Bhola', 'bn_name' => 'ভোলা',
                        'upazilas' => [
                            ['name' => 'Bhola Sadar', 'bn_name' => 'ভোলা সদর'],
                            ['name' => 'Burhanuddin', 'bn_name' => 'বুরহানউদ্দিন'],
                            ['name' => 'Char Fasson', 'bn_name' => 'চর ফ্যাসন'],
                            ['name' => 'Daulatkhan', 'bn_name' => 'দৌলতখান'],
                            ['name' => 'Lalmohan', 'bn_name' => 'লালমোহন'],
                            ['name' => 'Manpura', 'bn_name' => 'মনপুরা'],
                            ['name' => 'Tazumuddin', 'bn_name' => 'তজুমুদ্দিন'],
                        ],
                    ],
                    [
                        'name' => 'Jhalokati', 'bn_name' => 'ঝালকাঠী',
                        'upazilas' => [
                            ['name' => 'Jhalokati Sadar', 'bn_name' => 'ঝালকাঠী সদর'],
                            ['name' => 'Kathalia', 'bn_name' => 'কাঁঠালিয়া'],
                            ['name' => 'Nalchity', 'bn_name' => 'নলছিটি'],
                            ['name' => 'Rajapur', 'bn_name' => 'রাজাপুর'],
                        ],
                    ],
                    [
                        'name' => 'Patuakhali', 'bn_name' => 'পটুয়াখালী',
                        'upazilas' => [
                            ['name' => 'Bauphal', 'bn_name' => 'বাউফল'],
                            ['name' => 'Dashmina', 'bn_name' => 'দশমিনা'],
                            ['name' => 'Galachipa', 'bn_name' => 'গলাচিপা'],
                            ['name' => 'Kalapara', 'bn_name' => 'কালাপাড়া'],
                            ['name' => 'Mirzaganj', 'bn_name' => 'মির্জাগঞ্জ'],
                            ['name' => 'Patuakhali Sadar', 'bn_name' => 'পটুয়াখালী সদর'],
                            ['name' => 'Rangabali', 'bn_name' => 'রাঙ্গাবালী'],
                            ['name' => 'Dumki', 'bn_name' => 'দুমকি'],
                        ],
                    ],
                    [
                        'name' => 'Pirojpur', 'bn_name' => 'পিরোজপুর',
                        'upazilas' => [
                            ['name' => 'Bhandaria', 'bn_name' => 'ভাণ্ডারিয়া'],
                            ['name' => 'Kawkhali', 'bn_name' => 'কাউকালী'],
                            ['name' => 'Mathbaria', 'bn_name' => 'মঠবাড়িয়া'],
                            ['name' => 'Nazirpur', 'bn_name' => 'নাজিরপুর'],
                            ['name' => 'Pirojpur Sadar', 'bn_name' => 'পিরোজপুর সদর'],
                            ['name' => 'Nesarabad', 'bn_name' => 'নেছারাবাদ'],
                            ['name' => 'Zianagar', 'bn_name' => 'জিয়ানগর'],
                        ],
                    ],
                ],
            ],
            [
                'division' => ['name' => 'Chattogram', 'bn_name' => 'চট্টগ্রাম'],
                'districts' => [
                    [
                        'name' => 'Bandarban', 'bn_name' => 'বান্দরবান',
                        'upazilas' => [
                            ['name' => 'Bandarban Sadar', 'bn_name' => 'বান্দরবান সদর'],
                            ['name' => 'Alikadam', 'bn_name' => 'আলীকদম'],
                            ['name' => 'Naikhongchhari', 'bn_name' => 'নাইক্ষ্যংছড়ি'],
                            ['name' => 'Ruma', 'bn_name' => 'রুমা'],
                            ['name' => 'Rowangchhari', 'bn_name' => 'রোয়াংছড়ি'],
                            ['name' => 'Rojia', 'bn_name' => 'রাজবিলা'],
                            ['name' => 'Thanchi', 'bn_name' => 'থানচি'],
                        ],
                    ],
                    [
                        'name' => 'Brahmanbaria', 'bn_name' => 'ব্রাহ্মণবাড়িয়া',
                        'upazilas' => [
                            ['name' => 'Brahmanbaria Sadar', 'bn_name' => 'ব্রাহ্মণবাড়িয়া সদর'],
                            ['name' => 'Ashuganj', 'bn_name' => 'আশুগঞ্জ'],
                            ['name' => 'Kasba', 'bn_name' => 'কসবা'],
                            ['name' => 'Nabinagar', 'bn_name' => 'নবীনগর'],
                            ['name' => 'Nasirnagar', 'bn_name' => 'নাসিরনগর'],
                            ['name' => 'Sarail', 'bn_name' => 'সরাইল'],
                            ['name' => 'Akhaura', 'bn_name' => 'আখাউড়া'],
                            ['name' => 'Bancharampur', 'bn_name' => 'বাঞ্ছারামপুর'],
                            ['name' => 'Bijoy Nagar', 'bn_name' => 'বিজয়নগর'],
                        ],
                    ],
                    [
                        'name' => 'Chandpur', 'bn_name' => 'চাঁদপুর',
                        'upazilas' => [
                            ['name' => 'Chandpur Sadar', 'bn_name' => 'চাঁদপুর সদর'],
                            ['name' => 'Faridganj', 'bn_name' => 'ফরিদগঞ্জ'],
                            ['name' => 'Haimchar', 'bn_name' => 'হাইমচর'],
                            ['name' => 'Hajiganj', 'bn_name' => 'হাজিগঞ্জ'],
                            ['name' => 'Kachua', 'bn_name' => 'কচুয়া'],
                            ['name' => 'Matlab North', 'bn_name' => 'মতলব উত্তর'],
                            ['name' => 'Matlab South', 'bn_name' => 'মতলব দক্ষিণ'],
                            ['name' => 'Shahrasti', 'bn_name' => 'শাহরাস্তি'],
                        ],
                    ],
                    [
                        'name' => 'Chattogram', 'bn_name' => 'চট্টগ্রাম',
                        'upazilas' => [
                            ['name' => 'Anwara', 'bn_name' => 'আনোয়ারা'],
                            ['name' => 'Boalkhali', 'bn_name' => 'বোয়ালখালী'],
                            ['name' => 'Patia', 'bn_name' => 'পটিয়া'],
                            ['name' => 'Raozan', 'bn_name' => 'রাউজান'],
                            ['name' => 'Rangunia', 'bn_name' => 'রাঙ্গুনিয়া'],
                            ['name' => 'Sandwip', 'bn_name' => 'সন্দ্বীপ'],
                            ['name' => 'Sitakunda', 'bn_name' => 'সীতাকুণ্ড'],
                            ['name' => 'Mirsharai', 'bn_name' => 'মীরসরাই'],
                            ['name' => 'Hathazari', 'bn_name' => 'হাটহাজারী'],
                            ['name' => 'Fatikchhari', 'bn_name' => 'ফটিকছড়ি'],
                            ['name' => 'Lohagara', 'bn_name' => 'লোহাগাড়া'],
                            ['name' => 'Chandanaish', 'bn_name' => 'চন্দনাইশ'],
                            ['name' => 'Satkania', 'bn_name' => 'সাতকানিয়া'],
                            ['name' => 'Banshkhali', 'bn_name' => 'বাঁশখালী'],
                        ],
                    ],
                    [
                        'name' => 'Cumilla', 'bn_name' => 'কুমিল্লা',
                        'upazilas' => [
                            ['name' => 'Cumilla Sadar Dakshin', 'bn_name' => 'কুমিল্লা সদর দক্ষিণ'],
                            ['name' => 'Cumilla Sadar Uttar', 'bn_name' => 'কুমিল্লা সদর উত্তর'],
                            ['name' => 'Barura', 'bn_name' => 'বরুড়া'],
                            ['name' => 'Chandina', 'bn_name' => 'চান্দিনা'],
                            ['name' => 'Daudkandi', 'bn_name' => 'দাউদকান্দি'],
                            ['name' => 'Debidwar', 'bn_name' => 'দেবীদ্বার'],
                            ['name' => 'Homna', 'bn_name' => 'হোমনা'],
                            ['name' => 'Laksam', 'bn_name' => 'লাকসাম'],
                            ['name' => 'Muradnagar', 'bn_name' => 'মুরাদনগর'],
                            ['name' => 'Nangalkot', 'bn_name' => 'নাঙ্গলকোট'],
                            ['name' => 'Titas', 'bn_name' => 'তিতাস'],
                            ['name' => 'Burichang', 'bn_name' => 'বুড়িচং'],
                            ['name' => 'Brahmanpara', 'bn_name' => 'ব্রাহ্মণপাড়া'],
                            ['name' => 'Meghna', 'bn_name' => 'মেঘনা'],
                        ],
                    ],
                    [
                        'name' => 'Coxs Bazar', 'bn_name' => 'কক্সবাজার',
                        'upazilas' => [
                            ['name' => 'Coxs Bazar Sadar', 'bn_name' => 'কক্সবাজার সদর'],
                            ['name' => 'Chakaria', 'bn_name' => 'চকরিয়া'],
                            ['name' => 'Kutubdia', 'bn_name' => 'কুতুবদিয়া'],
                            ['name' => 'Maheshkhali', 'bn_name' => 'মহেশখালী'],
                            ['name' => 'Pekua', 'bn_name' => 'পেকুয়া'],
                            ['name' => 'Ramu', 'bn_name' => 'রামু'],
                            ['name' => 'Teknaf', 'bn_name' => 'টেকনাফ'],
                            ['name' => 'Ukhia', 'bn_name' => 'উখিয়া'],
                            ['name' => 'Eidgaon', 'bn_name' => 'ঈদগাঁও'],
                        ],
                    ],
                    [
                        'name' => 'Feni', 'bn_name' => 'ফেনী',
                        'upazilas' => [
                            ['name' => 'Feni Sadar', 'bn_name' => 'ফেনী সদর'],
                            ['name' => 'Chhagalnaiya', 'bn_name' => 'ছাগলনাইয়া'],
                            ['name' => 'Sonagazi', 'bn_name' => 'সোনাগাজী'],
                            ['name' => 'Fulgazi', 'bn_name' => 'ফুলগাজী'],
                            ['name' => 'Parshuram', 'bn_name' => 'পরশুরাম'],
                            ['name' => 'Daganbhuiyan', 'bn_name' => 'দাগনভূঞান'],
                        ],
                    ],
                    [
                        'name' => 'Khagrachhari', 'bn_name' => 'খাগড়াছড়ি',
                        'upazilas' => [
                            ['name' => 'Khagrachhari Sadar', 'bn_name' => 'খাগড়াছড়ি সদর'],
                            ['name' => 'Dighinala', 'bn_name' => 'দীঘিনালা'],
                            ['name' => 'Panchhari', 'bn_name' => 'পানছড়ি'],
                            ['name' => 'Laxmichhari', 'bn_name' => 'লক্ষ্মীছড়ি'],
                            ['name' => 'Mahalchhari', 'bn_name' => 'মহালছড়ি'],
                            ['name' => 'Manikchhari', 'bn_name' => 'মানিকছড়ি'],
                            ['name' => 'Ramgarh', 'bn_name' => 'রামগড়'],
                            ['name' => 'Matiranga', 'bn_name' => 'মাটিরাঙা'],
                            ['name' => 'Guimara', 'bn_name' => 'গুইমারা'],
                        ],
                    ],
                    [
                        'name' => 'Lakshmipur', 'bn_name' => 'লক্ষ্মীপুর',
                        'upazilas' => [
                            ['name' => 'Lakshmipur Sadar', 'bn_name' => 'লক্ষ্মীপুর সদর'],
                            ['name' => 'Raipura', 'bn_name' => 'রায়পুর'],
                            ['name' => 'Kamalnagar', 'bn_name' => 'কমলনগর'],
                            ['name' => 'Ramgati', 'bn_name' => 'রামগতি'],
                            ['name' => 'Ramganj', 'bn_name' => 'রামগঞ্জ'],
                        ],
                    ],
                    [
                        'name' => 'Noakhali', 'bn_name' => 'নোয়াখালী',
                        'upazilas' => [
                            ['name' => 'Noakhali Sadar', 'bn_name' => 'নোয়াখালী সদর'],
                            ['name' => 'Begumganj', 'bn_name' => 'বেগমগঞ্জ'],
                            ['name' => 'Chatkhil', 'bn_name' => 'চাটখিল'],
                            ['name' => 'Companiganj', 'bn_name' => 'কোম্পানীগঞ্জ'],
                            ['name' => 'Hatiya', 'bn_name' => 'হাতিয়া'],
                            ['name' => 'Kabirhat', 'bn_name' => 'কবিরহাট'],
                            ['name' => 'Senbagh', 'bn_name' => 'সেনবাগ'],
                            ['name' => 'Sonaimuri', 'bn_name' => 'সোনাইমুড়ি'],
                            ['name' => 'Subarnachar', 'bn_name' => 'সুবর্ণচর'],
                        ],
                    ],
                    [
                        'name' => 'Rangamati', 'bn_name' => 'রাঙামাটি',
                        'upazilas' => [
                            ['name' => 'Rangamati Sadar', 'bn_name' => 'রাঙামাটি সদর'],
                            ['name' => 'Bagaichhari', 'bn_name' => 'বাঘাইছড়ি'],
                            ['name' => 'Barkal', 'bn_name' => 'বরকল'],
                            ['name' => 'Kaptai', 'bn_name' => 'কাপ্তাই'],
                            ['name' => 'Juraichhari', 'bn_name' => 'জুরাছড়ি'],
                            ['name' => 'Kawkhali', 'bn_name' => 'কাউখালী'],
                            ['name' => 'Langadu', 'bn_name' => 'লংগদু'],
                            ['name' => 'Nannerchar', 'bn_name' => 'নানেরছড়'],
                            ['name' => 'Rajasthali', 'bn_name' => 'রাজস্থলী'],
                        ],
                    ],
                ],
            ],
            [
                'division' => ['name' => 'Dhaka', 'bn_name' => 'ঢাকা'],
                'districts' => [
                    [
                        'name' => 'Dhaka', 'bn_name' => 'ঢাকা',
                        'upazilas' => [
                            ['name' => 'Dhaka', 'bn_name' => 'ঢাকা'],
                            ['name' => 'Dhamrai', 'bn_name' => 'ধামরাই'],
                            ['name' => 'Dohar', 'bn_name' => 'দোহার'],
                            ['name' => 'Keraniganj', 'bn_name' => 'কেরানীগঞ্জ'],
                            ['name' => 'Nawabganj', 'bn_name' => 'নবাবগঞ্জ'],
                            ['name' => 'Savar', 'bn_name' => 'সাভার'],
                        ],
                    ],
                    [
                        'name' => 'Faridpur', 'bn_name' => 'ফরিদপুর',
                        'upazilas' => [
                            ['name' => 'Alfadanga', 'bn_name' => 'আলফাডাঙ্গা'],
                            ['name' => 'Bhanga', 'bn_name' => 'ভাঙ্গা'],
                            ['name' => 'Boalmari', 'bn_name' => 'বোয়ালমারী'],
                            ['name' => 'Charbhadrasan', 'bn_name' => 'চরভদ্রাসন'],
                            ['name' => 'Faridpur Sadar', 'bn_name' => 'ফরিদপুর সদর'],
                            ['name' => 'Madhukhali', 'bn_name' => 'মধুখালী'],
                            ['name' => 'Nagarkanda', 'bn_name' => 'নগরকান্দা'],
                            ['name' => 'Sadar', 'bn_name' => 'সাদরপুর'],
                            ['name' => 'Saltha', 'bn_name' => 'সালথা'],
                        ],
                    ],
                    [
                        'name' => 'Gazipur', 'bn_name' => 'গাজীপুর',
                        'upazilas' => [
                            ['name' => 'Gazipur Sadar', 'bn_name' => 'গাজীপুর সদর'],
                            ['name' => 'Kaliakair', 'bn_name' => 'কালিয়াকৈর'],
                            ['name' => 'Kaliganj', 'bn_name' => 'কালীগঞ্জ'],
                            ['name' => 'Kapasia', 'bn_name' => 'কাপাসিয়া'],
                            ['name' => 'Sreepur', 'bn_name' => 'শ্রীপুর'],
                        ],
                    ],
                    [
                        'name' => 'Gopalganj', 'bn_name' => 'গোপালগঞ্জ',
                        'upazilas' => [
                            ['name' => 'Gopalganj Sadar', 'bn_name' => 'গোপালগঞ্জ সদর'],
                            ['name' => 'Kashiani', 'bn_name' => 'কাশিয়ানী'],
                            ['name' => 'Kotalipara', 'bn_name' => 'কোটালীপাড়া'],
                            ['name' => 'Muksudpur', 'bn_name' => 'মুকসুদপুর'],
                            ['name' => 'Tungipara', 'bn_name' => 'টুঙ্গিপাড়া'],
                        ],
                    ],
                    [
                        'name' => 'Kishoreganj', 'bn_name' => 'কিশোরগঞ্জ',
                        'upazilas' => [
                            ['name' => 'Austagram', 'bn_name' => 'অষ্টগ্রাম'],
                            ['name' => 'Bajitpur', 'bn_name' => 'বাজিতপুর'],
                            ['name' => 'Bhairab', 'bn_name' => 'ভৈরব'],
                            ['name' => 'Hossainpur', 'bn_name' => 'হোসেনপুর'],
                            ['name' => 'Itna', 'bn_name' => 'ইটনা'],
                            ['name' => 'Karimganj', 'bn_name' => 'করিমগঞ্জ'],
                            ['name' => 'Katiadi', 'bn_name' => 'কটিয়াদী'],
                            ['name' => 'Kishoreganj Sadar', 'bn_name' => 'কিশোরগঞ্জ সদর'],
                            ['name' => 'Kuliarchar', 'bn_name' => 'কুলিয়ারচর'],
                            ['name' => 'Mithamain', 'bn_name' => 'মিঠামইন'],
                            ['name' => 'Nikli', 'bn_name' => 'নিকলী'],
                            ['name' => 'Pakundia', 'bn_name' => 'পাকুন্দিয়া'],
                            ['name' => 'Tarail', 'bn_name' => 'তারাইল'],
                        ],
                    ],
                    [
                        'name' => 'Madaripur', 'bn_name' => 'মাদারীপুর',
                        'upazilas' => [
                            ['name' => 'Madaripur Sadar', 'bn_name' => 'মাদারীপুর সদর'],
                            ['name' => 'Kalkini', 'bn_name' => 'কালকিনি'],
                            ['name' => 'Rajoir', 'bn_name' => 'রাজৈর'],
                            ['name' => 'Shibchar', 'bn_name' => 'শিবচর'],
                        ],
                    ],
                    [
                        'name' => 'Manikganj', 'bn_name' => 'মানিকগঞ্জ',
                        'upazilas' => [
                            ['name' => 'Manikganj Sadar', 'bn_name' => 'মানিকগঞ্জ সদর'],
                            ['name' => 'Daulatpur', 'bn_name' => 'দৌলতপুর'],
                            ['name' => 'Ghior', 'bn_name' => 'ঘিওর'],
                            ['name' => 'Harirampur', 'bn_name' => 'হরিরামপুর'],
                            ['name' => 'Saturia', 'bn_name' => 'সাটুরিয়া'],
                            ['name' => 'Shivalaya', 'bn_name' => 'শিবালয়া'],
                        ],
                    ],
                    [
                        'name' => 'Munshiganj', 'bn_name' => 'মুন্সীগঞ্জ',
                        'upazilas' => [
                            ['name' => 'Munshiganj Sadar', 'bn_name' => 'মুন্সীগঞ্জ সদর'],
                            ['name' => 'Lohajang', 'bn_name' => 'লৌহজং'],
                            ['name' => 'Sirajdikhan', 'bn_name' => 'সিরাজদিখান'],
                            ['name' => 'Sreenagar', 'bn_name' => 'শ্রীনগর'],
                            ['name' => 'Tongibari', 'bn_name' => 'টংগিবাড়ী'],
                            ['name' => 'Gazaria', 'bn_name' => 'গজারিয়া'],
                        ],
                    ],
                    [
                        'name' => 'Narayanganj', 'bn_name' => 'নারায়ণগঞ্জ',
                        'upazilas' => [
                            ['name' => 'Araihazar', 'bn_name' => 'আড়াইহাজার'],
                            ['name' => 'Bandar', 'bn_name' => 'বন্দর'],
                            ['name' => 'Narayanganj Sadar', 'bn_name' => 'নারায়ণগঞ্জ সদর'],
                            ['name' => 'Rupganj', 'bn_name' => 'রূপগঞ্জ'],
                            ['name' => 'Sonargaon', 'bn_name' => 'সোনারগাঁও'],
                        ],
                    ],
                    [
                        'name' => 'Narsingdi', 'bn_name' => 'নরসিংদী',
                        'upazilas' => [
                            ['name' => 'Belabo', 'bn_name' => 'বেলাবো'],
                            ['name' => 'Monohardi', 'bn_name' => 'মনোহরদী'],
                            ['name' => 'Narsingdi Sadar', 'bn_name' => 'নরসিংদী সদর'],
                            ['name' => 'Palash', 'bn_name' => 'পলাশ'],
                            ['name' => 'Raipura', 'bn_name' => 'রায়পুর'],
                            ['name' => 'Shibpur', 'bn_name' => 'শিবপুর'],
                        ],
                    ],
                    [
                        'name' => 'Rajbari', 'bn_name' => 'রাজবাড়ী',
                        'upazilas' => [
                            ['name' => 'Rajbari Sadar', 'bn_name' => 'রাজবাড়ী সদর'],
                            ['name' => 'Goalanda', 'bn_name' => 'গোয়ালন্দা'],
                            ['name' => 'Pangsha', 'bn_name' => 'পাংশা'],
                            ['name' => 'Baliakandi', 'bn_name' => 'বালিয়াকান্দি'],
                            ['name' => 'Kalukhali', 'bn_name' => 'কালুখালী'],
                        ],
                    ],
                    [
                        'name' => 'Shariatpur', 'bn_name' => 'শরীয়তপুর',
                        'upazilas' => [
                            ['name' => 'Shariatpur Sadar', 'bn_name' => 'শরীয়তপুর সদর'],
                            ['name' => 'Naria', 'bn_name' => 'নড়িয়া'],
                            ['name' => 'Zanjira', 'bn_name' => 'জাজিরা'],
                            ['name' => 'Gosairhat', 'bn_name' => 'গোসাইরহাট'],
                            ['name' => 'Bhedarganj', 'bn_name' => 'ভেদরগঞ্জ'],
                            ['name' => 'Damudya', 'bn_name' => 'দামুড্যা'],
                        ],
                    ],
                    [
                        'name' => 'Tangail', 'bn_name' => 'টাঙ্গাইল',
                        'upazilas' => [
                            ['name' => 'Tangail Sadar', 'bn_name' => 'টাঙ্গাইল সদর'],
                            ['name' => 'Basail', 'bn_name' => 'বসাইল'],
                            ['name' => 'Bhuapur', 'bn_name' => 'ভুয়াপুর'],
                            ['name' => 'Delduar', 'bn_name' => 'দেলদুয়ার'],
                            ['name' => 'Ghatail', 'bn_name' => 'ঘাটাইল'],
                            ['name' => 'Gopalpur', 'bn_name' => 'গোপালপুর'],
                            ['name' => 'Kalihati', 'bn_name' => 'কালিহাতী'],
                            ['name' => 'Madhupur', 'bn_name' => 'মধুপুর'],
                            ['name' => 'Mirzapur', 'bn_name' => 'মির্জাপুর'],
                            ['name' => 'Nagarpur', 'bn_name' => 'নাগরপুর'],
                            ['name' => 'Sakhipur', 'bn_name' => 'সখিপুর'],
                            ['name' => 'Dhanbari', 'bn_name' => 'ধনবাড়ী'],
                        ],
                    ],
                ],
            ],
            [
                'division' => ['name' => 'Khulna', 'bn_name' => 'খুলনা'],
                'districts' => [
                    [
                        'name' => 'Bagerhat', 'bn_name' => 'বাগেরহাট',
                        'upazilas' => [
                            ['name' => 'Bagerhat Sadar', 'bn_name' => 'বাগেরহাট সদর'],
                            ['name' => 'Chitalmari', 'bn_name' => 'চিতলমারী'],
                            ['name' => 'Fakirhat', 'bn_name' => 'ফকিরহাট'],
                            ['name' => 'Kachua', 'bn_name' => 'কচুয়া'],
                            ['name' => 'Mollahat', 'bn_name' => 'মোল্লাহাট'],
                            ['name' => 'Mongla', 'bn_name' => 'মংলা'],
                            ['name' => 'Morrelganj', 'bn_name' => 'মোড়লগঞ্জ'],
                            ['name' => 'Rampal', 'bn_name' => 'রামপাল'],
                            ['name' => 'Sarankhola', 'bn_name' => 'শরণখোলা'],
                        ],
                    ],
                    [
                        'name' => 'Chuadanga', 'bn_name' => 'চুয়াডাঙ্গা',
                        'upazilas' => [
                            ['name' => 'Chuadanga Sadar', 'bn_name' => 'চুয়াডাঙ্গা সদর'],
                            ['name' => 'Alamdanga', 'bn_name' => 'আলমডাঙ্গা'],
                            ['name' => 'Jibannagar', 'bn_name' => 'জীবননগর'],
                            ['name' => 'Damurhuda', 'bn_name' => 'দামুড়হুদা'],
                        ],
                    ],
                    [
                        'name' => 'Jashore', 'bn_name' => 'যশোর',
                        'upazilas' => [
                            ['name' => 'Abhaynagar', 'bn_name' => 'অভয়নগর'],
                            ['name' => 'Bagherpara', 'bn_name' => 'বাঘারপাড়া'],
                            ['name' => 'Chaugachha', 'bn_name' => 'চৌগাছা'],
                            ['name' => 'Jashore Sadar', 'bn_name' => 'যশোর সদর'],
                            ['name' => 'Jhikargachha', 'bn_name' => 'ঝিকরগাছা'],
                            ['name' => 'Keshabpur', 'bn_name' => 'কেশবপুর'],
                            ['name' => 'Manirampur', 'bn_name' => 'মণিরামপুর'],
                            ['name' => 'Sharsha', 'bn_name' => 'সারশা'],
                        ],
                    ],
                    [
                        'name' => 'Jhenaidah', 'bn_name' => 'ঝিনাইদহ',
                        'upazilas' => [
                            ['name' => 'Jhenaidah Sadar', 'bn_name' => 'ঝিনাইদহ সদর'],
                            ['name' => 'Harinakunda', 'bn_name' => 'হরিণাকুন্ডু'],
                            ['name' => 'Kaliganj', 'bn_name' => 'কালীগঞ্জ'],
                            ['name' => 'Kotchandpur', 'bn_name' => 'কোটচাঁদপুর'],
                            ['name' => 'Maheshpur', 'bn_name' => 'মহেশপুর'],
                            ['name' => 'Shailkupa', 'bn_name' => 'শৈলকুপা'],
                        ],
                    ],
                    [
                        'name' => 'Khulna', 'bn_name' => 'খুলনা',
                        'upazilas' => [
                            ['name' => 'Batiaghata', 'bn_name' => 'বটিয়াঘাটা'],
                            ['name' => 'Dakope', 'bn_name' => 'দাকোপ'],
                            ['name' => 'Dumuria', 'bn_name' => 'দৌমুরিয়া'],
                            ['name' => 'Dighalia', 'bn_name' => 'দিঘলিয়া'],
                            ['name' => 'Koyra', 'bn_name' => 'কয়রা'],
                            ['name' => 'Paikgachha', 'bn_name' => 'পাইকগাছা'],
                            ['name' => 'Phultala', 'bn_name' => 'ফুলতলা'],
                            ['name' => 'Rupsha', 'bn_name' => 'রূপসা'],
                            ['name' => 'Terokhada', 'bn_name' => 'তেরখাদা'],
                        ],
                    ],
                    [
                        'name' => 'Kushtia', 'bn_name' => 'কুষ্টিয়া',
                        'upazilas' => [
                            ['name' => 'Kushtia Sadar', 'bn_name' => 'কুষ্টিয়া সদর'],
                            ['name' => 'Bheramara', 'bn_name' => 'ভেড়ামারা'],
                            ['name' => 'Daulatpur', 'bn_name' => 'দৌলতপুর'],
                            ['name' => 'Khoksa', 'bn_name' => 'খোকসা'],
                            ['name' => 'Kumarkhali', 'bn_name' => 'কুমারখালী'],
                            ['name' => 'Mirpur', 'bn_name' => 'মিরপুর'],
                        ],
                    ],
                    [
                        'name' => 'Magura', 'bn_name' => 'মাগুরা',
                        'upazilas' => [
                            ['name' => 'Magura Sadar', 'bn_name' => 'মাগুরা সদর'],
                            ['name' => 'Mohammadpur', 'bn_name' => 'মোহাম্মদপুর'],
                            ['name' => 'Salikha', 'bn_name' => 'শালিখা'],
                            ['name' => 'Sreepur', 'bn_name' => 'শ্রীপুর'],
                        ],
                    ],
                    [
                        'name' => 'Meherpur', 'bn_name' => 'মেহেরপুর',
                        'upazilas' => [
                            ['name' => 'Meherpur Sadar', 'bn_name' => 'মেহেরপুর সদর'],
                            ['name' => 'Gangni', 'bn_name' => 'গাংনী'],
                            ['name' => 'Mujibnagar', 'bn_name' => 'মুজিবনগর'],
                        ],
                    ],
                    [
                        'name' => 'Narail', 'bn_name' => 'নড়াইল',
                        'upazilas' => [
                            ['name' => 'Narail Sadar', 'bn_name' => 'নড়াইল সদর'],
                            ['name' => 'Kalia', 'bn_name' => 'কালিয়া'],
                            ['name' => 'Lohagara', 'bn_name' => 'লোহাগড়া'],
                        ],
                    ],
                    [
                        'name' => 'Satkhira', 'bn_name' => 'সাতক্ষীরা',
                        'upazilas' => [
                            ['name' => 'Satkhira Sadar', 'bn_name' => 'সাতক্ষীরা সদর'],
                            ['name' => 'Assasuni', 'bn_name' => 'আশাশুনি'],
                            ['name' => 'Debhata', 'bn_name' => 'দেবহাটা'],
                            ['name' => 'Kalaroa', 'bn_name' => 'কালারোয়া'],
                            ['name' => 'Kaliganj', 'bn_name' => 'কালীগঞ্জ'],
                            ['name' => 'Shyamnagar', 'bn_name' => 'শ্যামনগর'],
                            ['name' => 'Tala', 'bn_name' => 'তালা'],
                        ],
                    ],
                ],
            ],
            [
                'division' => ['name' => 'Mymensingh', 'bn_name' => 'ময়মনসিংহ'],
                'districts' => [
                    [
                        'name' => 'Jamalpur', 'bn_name' => 'জামালপুর',
                        'upazilas' => [
                            ['name' => 'Jamalpur Sadar', 'bn_name' => 'জামালপুর সদর'],
                            ['name' => 'Dewanganj', 'bn_name' => 'দেওয়ানগঞ্জ'],
                            ['name' => 'Islampur', 'bn_name' => 'ইসলামপুর'],
                            ['name' => 'Madarganj', 'bn_name' => 'মাদারগঞ্জ'],
                            ['name' => 'Melandaha', 'bn_name' => 'মেলান্দহা'],
                            ['name' => 'Sarishabari', 'bn_name' => 'সরিষাবাড়ী'],
                            ['name' => 'Baksiganj', 'bn_name' => 'বকশিগঞ্জ'],
                        ],
                    ],
                    [
                        'name' => 'Mymensingh', 'bn_name' => 'ময়মনসিংহ',
                        'upazilas' => [
                            ['name' => 'Mymensingh Sadar', 'bn_name' => 'ময়মনসিংহ সদর'],
                            ['name' => 'Bhaluka', 'bn_name' => 'ভালুকা'],
                            ['name' => 'Dhobaura', 'bn_name' => 'ধোবাউড়া'],
                            ['name' => 'Fulbaria', 'bn_name' => 'ফুলবাড়িয়া'],
                            ['name' => 'Gaffargaon', 'bn_name' => 'গফরগাঁও'],
                            ['name' => 'Gouripur', 'bn_name' => 'গৌরীপুর'],
                            ['name' => 'Haluaghat', 'bn_name' => 'হালুয়াঘাট'],
                            ['name' => 'Ishwarganj', 'bn_name' => 'ঈশ্বরগঞ্জ'],
                            ['name' => 'Muktagachha', 'bn_name' => 'মুক্তাগাছা'],
                            ['name' => 'Nandail', 'bn_name' => 'নান্দাইল'],
                            ['name' => 'Phulpur', 'bn_name' => 'ফুলপুর'],
                            ['name' => 'Tarakanda', 'bn_name' => 'তারাকান্দা'],
                            ['name' => 'Trishal', 'bn_name' => 'ত্রিশাল'],
                        ],
                    ],
                    [
                        'name' => 'Netrokona', 'bn_name' => 'নেত্রকোনা',
                        'upazilas' => [
                            ['name' => 'Netrokona Sadar', 'bn_name' => 'নেত্রকোনা সদর'],
                            ['name' => 'Atpara', 'bn_name' => 'আটপাড়া'],
                            ['name' => 'Barhatta', 'bn_name' => 'বারহাট্টা'],
                            ['name' => 'Durgapur', 'bn_name' => 'দুর্গাপুর'],
                            ['name' => 'Kendua', 'bn_name' => 'কেন্দুয়া'],
                            ['name' => 'Khaliajuri', 'bn_name' => 'খালিয়াজুড়ি'],
                            ['name' => 'Kalmakanda', 'bn_name' => 'কলমাকান্দা'],
                            ['name' => 'Madan', 'bn_name' => 'মদন'],
                            ['name' => 'Mohanganj', 'bn_name' => 'মোহনগঞ্জ'],
                            ['name' => 'Purbadhala', 'bn_name' => 'পূর্বধলা'],
                        ],
                    ],
                    [
                        'name' => 'Sherpur', 'bn_name' => 'শেরপুর',
                        'upazilas' => [
                            ['name' => 'Sherpur Sadar', 'bn_name' => 'শেরপুর সদর'],
                            ['name' => 'Jhenaigati', 'bn_name' => 'ঝিনাগাতি'],
                            ['name' => 'Nakla', 'bn_name' => 'নাকলা'],
                            ['name' => 'Nalitabari', 'bn_name' => 'নলিতাবাড়ী'],
                            ['name' => 'Sreebardi', 'bn_name' => 'শ্রীবরদী'],
                        ],
                    ],
                ],
            ],
            [
                'division' => ['name' => 'Rajshahi', 'bn_name' => 'রাজশাহী'],
                'districts' => [
                    [
                        'name' => 'Bogura', 'bn_name' => 'বগুড়া',
                        'upazilas' => [
                            ['name' => 'Bogura Sadar', 'bn_name' => 'বগুড়া সদর'],
                            ['name' => 'Adamdighi', 'bn_name' => 'আদমদিঘী'],
                            ['name' => 'Dhunat', 'bn_name' => 'ধুনট'],
                            ['name' => 'Dhupchanchia', 'bn_name' => 'ধুপচাঁচিয়া'],
                            ['name' => 'Gabtali', 'bn_name' => 'গাবতলী'],
                            ['name' => 'Kahaloo', 'bn_name' => 'কাহালু'],
                            ['name' => 'Nandigram', 'bn_name' => 'নন্দীগ্রাম'],
                            ['name' => 'Sariakandi', 'bn_name' => 'শাজাহানপুর'],
                            ['name' => 'Shajahanpur', 'bn_name' => 'শাজাহানপুর'],
                            ['name' => 'Sherpur', 'bn_name' => 'শেরপুর'],
                            ['name' => 'Shibganj', 'bn_name' => 'শিবগঞ্জ'],
                            ['name' => 'Sonatala', 'bn_name' => 'সোনাতলা'],
                        ],
                    ],
                    [
                        'name' => 'Chapainawabganj', 'bn_name' => 'চাঁপাইনবাবগঞ্জ',
                        'upazilas' => [
                            ['name' => 'Chapainawabganj Sadar', 'bn_name' => 'চাঁপাইনবাবগঞ্জ সদর'],
                            ['name' => 'Gomostapur', 'bn_name' => 'গোমস্তাপুর'],
                            ['name' => 'Shibganj', 'bn_name' => 'শিবগঞ্জ'],
                            ['name' => 'Bholahat', 'bn_name' => 'ভোলাহাট'],
                            ['name' => 'Nawabganj', 'bn_name' => 'নবাবগঞ্জ'],
                            ['name' => 'Nachole', 'bn_name' => 'নাচোলে'],
                            ['name' => 'Alamdanga', 'bn_name' => 'আলমডাঙ্গা'],
                            ['name' => 'Haripur', 'bn_name' => 'হরিপুর'],
                        ],
                    ],
                    [
                        'name' => 'Joypurhat', 'bn_name' => 'জয়পুরহাট',
                        'upazilas' => [
                            ['name' => 'Joypurhat Sadar', 'bn_name' => 'জয়পুরহাট সদর'],
                            ['name' => 'Akkelpur', 'bn_name' => 'আক্কেলপুর'],
                            ['name' => 'Kalai', 'bn_name' => 'কালাই'],
                            ['name' => 'Khetlal', 'bn_name' => 'খেতলাল'],
                            ['name' => 'Panchbibi', 'bn_name' => 'পাঁচবিবি'],
                        ],
                    ],
                    [
                        'name' => 'Naogaon', 'bn_name' => 'নওগাঁও',
                        'upazilas' => [
                            ['name' => 'Naogaon Sadar', 'bn_name' => 'নওগাঁও সদর'],
                            ['name' => 'Badalgachhi', 'bn_name' => 'বাদলগাছি'],
                            ['name' => 'Dhamoirhat', 'bn_name' => 'ধামইরহাট'],
                            ['name' => 'Mohadevpur', 'bn_name' => 'মহাদেবপুর'],
                            ['name' => 'Manda', 'bn_name' => 'মান্দা'],
                            ['name' => 'Niamatpur', 'bn_name' => 'নিয়ামতপুর'],
                            ['name' => 'Parbatipur', 'bn_name' => 'পার্বতীপুর'],
                            ['name' => 'Patnitala', 'bn_name' => 'পত্নীতলা'],
                            ['name' => 'Raninagar', 'bn_name' => 'রাণীনগর'],
                            ['name' => 'Sapahar', 'bn_name' => 'সাপাহার'],
                            ['name' => 'Atrai', 'bn_name' => 'আত্রাই'],
                        ],
                    ],
                    [
                        'name' => 'Natore', 'bn_name' => 'নাটোর',
                        'upazilas' => [
                            ['name' => 'Natore Sadar', 'bn_name' => 'নাটোর সদর'],
                            ['name' => 'Bagatipara', 'bn_name' => 'বাগাতিপাড়া'],
                            ['name' => 'Baraigram', 'bn_name' => 'বারাইগ্রাম'],
                            ['name' => 'Gurudaspur', 'bn_name' => 'গুরুদাসপুর'],
                            ['name' => 'Lalpur', 'bn_name' => 'লালপুর'],
                            ['name' => 'Singra', 'bn_name' => 'সিংড়া'],
                        ],
                    ],
                    [
                        'name' => 'Pabna', 'bn_name' => 'পাবনা',
                        'upazilas' => [
                            ['name' => 'Pabna Sadar', 'bn_name' => 'পাবনা সদর'],
                            ['name' => 'Bera', 'bn_name' => 'বেড়া'],
                            ['name' => 'Bhangura', 'bn_name' => 'ভাঙ্গুড়া'],
                            ['name' => 'Faridpur', 'bn_name' => 'ফরিদপুর'],
                            ['name' => 'Ishwardi', 'bn_name' => 'ঈশ্বরদী'],
                            ['name' => 'Sathia', 'bn_name' => 'সাথিয়া'],
                            ['name' => 'Sujanagar', 'bn_name' => 'সুজানগর'],
                            ['name' => 'Atghoria', 'bn_name' => 'আটঘরিয়া'],
                            ['name' => 'Chatmohor', 'bn_name' => 'চাটমহর'],
                        ],
                    ],
                    [
                        'name' => 'Rajshahi', 'bn_name' => 'রাজশাহী',
                        'upazilas' => [
                            ['name' => 'Rajshahi Sadar', 'bn_name' => 'রাজশাহী সদর'],
                            ['name' => 'Bagmara', 'bn_name' => 'বাগমারা'],
                            ['name' => 'Charghat', 'bn_name' => 'চারঘাট'],
                            ['name' => 'Durgapur', 'bn_name' => 'দুর্গাপুর'],
                            ['name' => 'Godagari', 'bn_name' => 'গোদাগাড়ি'],
                            ['name' => 'Mohanpur', 'bn_name' => 'মোহনপুর'],
                            ['name' => 'Paba', 'bn_name' => 'পবা'],
                            ['name' => 'Puthia', 'bn_name' => 'পুঠিয়া'],
                            ['name' => 'Tanore', 'bn_name' => 'তানোর'],
                        ],
                    ],
                    [
                        'name' => 'Sirajganj', 'bn_name' => 'সিরাজগঞ্জ',
                        'upazilas' => [
                            ['name' => 'Sirajganj Sadar', 'bn_name' => 'সিরাজগঞ্জ সদর'],
                            ['name' => 'Belkuchi', 'bn_name' => 'বেলকুচি'],
                            ['name' => 'Chowhali', 'bn_name' => 'চৌহালী'],
                            ['name' => 'Kamarkhanda', 'bn_name' => 'কামারখান্দা'],
                            ['name' => 'Kazipur', 'bn_name' => 'কাজীপুর'],
                            ['name' => 'Raiganj', 'bn_name' => 'রায়গঞ্জ'],
                            ['name' => 'Shahjadpur', 'bn_name' => 'শাহজাদপুর'],
                            ['name' => 'Tarash', 'bn_name' => 'তাড়াশ'],
                            ['name' => 'Ullahpara', 'bn_name' => 'উল্লাপাড়া'],
                        ],
                    ],
                ],
            ],
            [
                'division' => ['name' => 'Rangpur', 'bn_name' => 'রংপুর'],
                'districts' => [
                    [
                        'name' => 'Dinajpur', 'bn_name' => 'দিনাজপুর',
                        'upazilas' => [
                            ['name' => 'Dinajpur Sadar', 'bn_name' => 'দিনাজপুর সদর'],
                            ['name' => 'Birganj', 'bn_name' => 'বিরগঞ্জ'],
                            ['name' => 'Ghoraghat', 'bn_name' => 'ঘোড়াঘাট'],
                            ['name' => 'Chirirbandar', 'bn_name' => 'চিরিরবন্দর'],
                            ['name' => 'Phulbari', 'bn_name' => 'ফুলবাড়ি'],
                            ['name' => 'Gobindaganj', 'bn_name' => 'গোবিন্দগঞ্জ'],
                            ['name' => 'Hakimpur', 'bn_name' => 'হাকিমপুর'],
                            ['name' => 'Kaharole', 'bn_name' => 'কাহারোল'],
                            ['name' => 'Khansama', 'bn_name' => 'খানসামা'],
                            ['name' => 'Ruilwala', 'bn_name' => 'রুইলওয়ালা'],
                            ['name' => 'Saidpur', 'bn_name' => 'সৈয়দপুর'],
                            ['name' => 'Sapahar', 'bn_name' => 'সাপাহার'],
                            ['name' => 'Sundarganj', 'bn_name' => 'সুন্দরগঞ্জ'],
                        ],
                    ],
                    [
                        'name' => 'Gaibandha', 'bn_name' => 'গাইবান্ধা',
                        'upazilas' => [
                            ['name' => 'Gaibandha Sadar', 'bn_name' => 'গাইবান্ধা সদর'],
                            ['name' => 'Fulchhari', 'bn_name' => 'ফুলছড়ি'],
                            ['name' => 'Gobindaganj', 'bn_name' => 'গোবিন্দগঞ্জ'],
                            ['name' => 'Saghata', 'bn_name' => 'সাঘাটা'],
                            ['name' => 'Sundarganj', 'bn_name' => 'সুন্দরগঞ্জ'],
                            ['name' => 'Palashbari', 'bn_name' => 'পলাশবাড়ি'],
                            ['name' => 'Ulipur', 'bn_name' => 'উলিপুর'],
                        ],
                    ],
                    [
                        'name' => 'Kurigram', 'bn_name' => 'কুড়িগ্রাম',
                        'upazilas' => [
                            ['name' => 'Kurigram Sadar', 'bn_name' => 'কুড়িগ্রাম সদর'],
                            ['name' => 'Bhurungamari', 'bn_name' => 'ভুরুঙ্গামারী'],
                            ['name' => 'Chilmari', 'bn_name' => 'চিলমারী'],
                            ['name' => 'Fulbari', 'bn_name' => 'ফুলবাড়ি'],
                            ['name' => 'Nageshwari', 'bn_name' => 'নাগেশ্বরী'],
                            ['name' => 'Phulbari', 'bn_name' => 'ফুলবাড়ি'],
                            ['name' => 'Rajarhat', 'bn_name' => 'রাজারহাট'],
                            ['name' => 'Rajibpur', 'bn_name' => 'রাজীবপুর'],
                            ['name' => 'Rowmari', 'bn_name' => 'রৌমারী'],
                            ['name' => 'Shibchar', 'bn_name' => 'শিবচর'],
                            ['name' => 'Ulipur', 'bn_name' => 'উলিপুর'],
                            ['name' => 'Chharchora', 'bn_name' => 'ছারছোড়া'],
                        ],
                    ],
                    [
                        'name' => 'Lalmonirhat', 'bn_name' => 'লালমনিরহাট',
                        'upazilas' => [
                            ['name' => 'Lalmonirhat Sadar', 'bn_name' => 'লালমনিরহাট সদর'],
                            ['name' => 'Aditmari', 'bn_name' => 'আদিতমারী'],
                            ['name' => 'Hatibandha', 'bn_name' => 'হাতিবন্ধা'],
                            ['name' => 'Kaliganj', 'bn_name' => 'কালীগঞ্জ'],
                            ['name' => 'Patgram', 'bn_name' => 'পাটগ্রাম'],
                        ],
                    ],
                    [
                        'name' => 'Nilphamari', 'bn_name' => 'নীলফামারী',
                        'upazilas' => [
                            ['name' => 'Nilphamari Sadar', 'bn_name' => 'নীলফামারী সদর'],
                            ['name' => 'Dimla', 'bn_name' => 'ডিমলা'],
                            ['name' => 'Domar', 'bn_name' => 'ডোমার'],
                            ['name' => 'Jaldhaka', 'bn_name' => 'জলঢাকা'],
                            ['name' => 'Kishoreganj', 'bn_name' => 'কিশোরগঞ্জ'],
                            ['name' => 'Saidpur', 'bn_name' => 'সৈয়দপুর'],
                        ],
                    ],
                    [
                        'name' => 'Panchagarh', 'bn_name' => 'পঞ্চগড়',
                        'upazilas' => [
                            ['name' => 'Panchagarh Sadar', 'bn_name' => 'পঞ্চগড় সদর'],
                            ['name' => 'Amgaon', 'bn_name' => 'আমগাঁও'],
                            ['name' => 'Atwari', 'bn_name' => 'আটোয়ারী'],
                            ['name' => 'Boda', 'bn_name' => 'বোদা'],
                            ['name' => 'Debiganj', 'bn_name' => 'দেবীগঞ্জ'],
                            ['name' => 'Tetulia', 'bn_name' => 'তেতুলিয়া'],
                        ],
                    ],
                    [
                        'name' => 'Rangpur', 'bn_name' => 'রংপুর',
                        'upazilas' => [
                            ['name' => 'Rangpur Sadar', 'bn_name' => 'রংপুর সদর'],
                            ['name' => 'Badarganj', 'bn_name' => 'বদরগঞ্জ'],
                            ['name' => 'Pirganj', 'bn_name' => 'পীরগঞ্জ'],
                            ['name' => 'Pirgachha', 'bn_name' => 'পীরগাছা'],
                            ['name' => 'Gangachara', 'bn_name' => 'গঙ্গাছড়া'],
                            ['name' => 'Kawnia', 'bn_name' => 'কাউনিয়া'],
                            ['name' => 'Mithapukur', 'bn_name' => 'মিঠাপুকুর'],
                            ['name' => 'Taraganj', 'bn_name' => 'তারাগঞ্জ'],
                        ],
                    ],
                    [
                        'name' => 'Thakurgaon', 'bn_name' => 'ঠাকুরগাঁও',
                        'upazilas' => [
                            ['name' => 'Thakurgaon Sadar', 'bn_name' => 'ঠাকুরগাঁও সদর'],
                            ['name' => 'Pirganj', 'bn_name' => 'পীরগঞ্জ'],
                            ['name' => 'Ranisankail', 'bn_name' => 'রাণীশংকৈল'],
                            ['name' => 'Baliadangi', 'bn_name' => 'বালিয়াডাঙ্গী'],
                            ['name' => 'Haripur', 'bn_name' => 'হরিপুর'],
                        ],
                    ],
                ],
            ],
            [
                'division' => ['name' => 'Sylhet', 'bn_name' => 'সিলেট'],
                'districts' => [
                    [
                        'name' => 'Habiganj', 'bn_name' => 'হবিগঞ্জ',
                        'upazilas' => [
                            ['name' => 'Habiganj Sadar', 'bn_name' => 'হবিগঞ্জ সদর'],
                            ['name' => 'Akhaura', 'bn_name' => 'আখাউরা'],
                            ['name' => 'Baniachong', 'bn_name' => 'বানিয়াচং'],
                            ['name' => 'Bahubal', 'bn_name' => 'বাহুবল'],
                            ['name' => 'Chunarughat', 'bn_name' => 'চুনারুঘাট'],
                            ['name' => 'Habiganj', 'bn_name' => 'হবিগঞ্জ'],
                            ['name' => 'Lakhai', 'bn_name' => 'লাখাই'],
                            ['name' => 'Madhabpur', 'bn_name' => 'মাধবপুর'],
                            ['name' => 'Nabiganj', 'bn_name' => 'নবীগঞ্জ'],
                        ],
                    ],
                    [
                        'name' => 'Moulvibazar', 'bn_name' => 'মৌলভীবাজার',
                        'upazilas' => [
                            ['name' => 'Moulvibazar Sadar', 'bn_name' => 'মৌলভীবাজার সদর'],
                            ['name' => 'Barlekha', 'bn_name' => 'বড়লেখা'],
                            ['name' => 'Juri', 'bn_name' => 'জুড়ি'],
                            ['name' => 'Kamalganj', 'bn_name' => 'কামালগঞ্জ'],
                            ['name' => 'Kulaura', 'bn_name' => 'কুলাউড়া'],
                            ['name' => 'Rajnagar', 'bn_name' => 'রাজনগর'],
                            ['name' => 'Sreemangal', 'bn_name' => 'শ্রীমঙ্গল'],
                        ],
                    ],
                    [
                        'name' => 'Sunamganj', 'bn_name' => 'সুনামগঞ্জ',
                        'upazilas' => [
                            ['name' => 'Sunamganj Sadar', 'bn_name' => 'সুনামগঞ্জ সদর'],
                            ['name' => 'Bishwambarpur', 'bn_name' => 'বিশ্বম্বরপুর'],
                            ['name' => 'Chhatak', 'bn_name' => 'ছাতক'],
                            ['name' => 'Derai', 'bn_name' => 'দেরাই'],
                            ['name' => 'Dowarabazar', 'bn_name' => 'দোয়ারাবাজার'],
                            ['name' => 'Dharampasha', 'bn_name' => 'ধরমপাশা'],
                            ['name' => 'Jagannathpur', 'bn_name' => 'জগন্নাথপুর'],
                            ['name' => 'Jamalganj', 'bn_name' => 'জামালগঞ্জ'],
                            ['name' => 'Sullah', 'bn_name' => 'সুলতান'],
                            ['name' => 'Shantiganj', 'bn_name' => 'শান্তিগঞ্জ'],
                            ['name' => 'Tahirpur', 'bn_name' => 'তাহিরপুর'],
                        ],
                    ],
                    [
                        'name' => 'Sylhet', 'bn_name' => 'সিলেট',
                        'upazilas' => [
                            ['name' => 'Sylhet Sadar', 'bn_name' => 'সিলেট সদর'],
                            ['name' => 'Balaganj', 'bn_name' => 'বালাগঞ্জ'],
                            ['name' => 'Beanibazar', 'bn_name' => 'বেনিবাজার'],
                            ['name' => 'Bishwanath', 'bn_name' => 'বিশ্বনাথ'],
                            ['name' => 'Companiganj', 'bn_name' => 'কোম্পানীগঞ্জ'],
                            ['name' => 'Fenchuganj', 'bn_name' => 'ফেঞ্চুগঞ্জ'],
                            ['name' => 'Golapganj', 'bn_name' => 'গোলাপগঞ্জ'],
                            ['name' => 'Jaintiapur', 'bn_name' => 'জৈন্তাপুর'],
                            ['name' => 'Kanaighat', 'bn_name' => 'কানাইঘাট'],
                            ['name' => 'Zakiganj', 'bn_name' => 'জাকিরগঞ্জ'],
                            ['name' => 'South Surma', 'bn_name' => 'দক্ষিণ সুরমা'],
                            ['name' => 'Oskhani', 'bn_name' => 'ওসখানী'],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($locations as $location) {
            $division = Division::create([
                'name' => $location['division']['name'],
                'bn_name' => $location['division']['bn_name'],
                'is_active' => true,
            ]);

            foreach ($location['districts'] as $districtData) {
                $district = District::create([
                    'division_id' => $division->id,
                    'name' => $districtData['name'],
                    'bn_name' => $districtData['bn_name'],
                    'is_active' => true,
                ]);

                foreach ($districtData['upazilas'] as $upazilaData) {
                    Upazila::create([
                        'district_id' => $district->id,
                        'name' => $upazilaData['name'],
                        'bn_name' => $upazilaData['bn_name'],
                        'is_active' => true,
                    ]);
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
