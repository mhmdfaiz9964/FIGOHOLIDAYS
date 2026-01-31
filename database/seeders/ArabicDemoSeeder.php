<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomePageHero;
use App\Models\TransportationPage;
use App\Models\Destination;
use App\Models\Province;
use Illuminate\Support\Facades\DB;

class ArabicDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clear existing data for these specific models to avoid duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        HomePageHero::truncate();
        TransportationPage::truncate();
        Destination::truncate();
        Province::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Seed Provinces (Arabic)
        $provinces = [
            ['name' => 'المقاطعة الوسطى'],
            ['name' => 'المقاطعة الغربية'],
            ['name' => 'المقاطعة الجنوبية'],
            ['name' => 'مقاطعة ساباراغاموا'],
        ];

        foreach ($provinces as $province) {
            Province::create($province);
        }

        $central = Province::where('name', 'المقاطعة الوسطى')->first();
        $western = Province::where('name', 'المقاطعة الغربية')->first();
        $southern = Province::where('name', 'المقاطعة الجنوبية')->first();

        // 3. Seed Home Page (Main Banner)
        HomePageHero::create([
            'tag' => 'عروض حصرية لعام 2026',
            'tag_size' => '16',
            'title' => 'سريلانكا بعيون',
            'title_size' => '65',
            'highlighted_title' => 'عربية أصيلة',
            'highlight_size' => '65',
            'description' => 'رحلات فاخرة مصممة خصيصاً للمسافر الخليجي ، تجمع بين الأصواة والرفاهية في قلب الطبيعة الخلابة.',
            'description_size' => '18',
            'btn1_text' => 'استشارة مجانية',
            'btn1_url' => '#',
            'btn2_text' => 'تصفح برامجنا',
            'btn2_url' => '#',
            'background_images' => [
                'https://images.unsplash.com/photo-1546708973-b339540b5162?q=80&w=2000&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1578330132822-0197066fd04d?q=80&w=2000&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1552423814-3532f8df786c?q=80&w=2000&auto=format&fit=crop'
            ],
            'status' => 'active'
        ]);

        // 4. Seed Transportation Page
        TransportationPage::create([
            'main_title' => 'تأجير السيارات مع سائق',
            'main_subtitle' => 'أسطول من السيارات الحديثة والفاخرة بأسعار تبدأ من 60 دولاراً',
            'image_01' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=1000&auto=format&fit=crop',
            'image_02' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58ae?q=80&w=1000&auto=format&fit=crop',
            'faqs' => [
                ['question' => 'هل تكاليف الوقود مشمولة في السعر؟', 'answer' => 'نعم ، جميع أسعارنا تشمل الوقود ورسوم السائق والضرائب.'],
                ['question' => 'هل السائق يتحدث اللغة العربية؟', 'answer' => 'لدينا مجموعة من السائقين المحترفين الذين يتحدثون العربية والإنجليزية.'],
                ['question' => 'هل يمكننا تغيير مسار الرحلة أثناء السفر؟', 'answer' => 'بالتأكيد ، نسعى دائماً لتلبية رغباتكم ومرونة المسارات هي ميزتنا.']
            ]
        ]);

        // 5. Seed Destinations (Arabic)
        $destinations = [
            [
                'name' => 'كاندي',
                'label' => 'العاصمة الثقافية',
                'province_id' => $central->id,
                'description' => 'تقع في قلب الجزيرة وتشتهر بكونها موطناً لمعبد السن والحدائق الملكية الخلابة.',
                'image' => 'https://images.unsplash.com/photo-1586902197503-e18641a18206?q=80&w=800&auto=format&fit=crop',
                'attractions' => [
                    ['title' => 'معبد السن المقدس', 'image' => 'https://images.unsplash.com/photo-1610413340536-11f8b3944321?q=80&w=400&auto=format&fit=crop'],
                    ['title' => 'الحديقة النباتية الملكية', 'image' => 'https://images.unsplash.com/photo-1582236528751-2292f2590204?q=80&w=400&auto=format&fit=crop']
                ]
            ],
            [
                'name' => 'كولومبو',
                'label' => 'العاصمة التجارية',
                'province_id' => $western->id,
                'description' => 'مدينة نابضة بالحياة تجمع بين العمارة الاستعمارية وناطحات السحاب الحديثة والتسوق الفاخر.',
                'image' => 'https://images.unsplash.com/photo-1584852504993-9092490fd363?q=80&w=800&auto=format&fit=crop',
                'attractions' => [
                    ['title' => 'متحف كولومبو الوطني', 'image' => 'https://images.unsplash.com/photo-1590432168953-6a97ff96700c?q=80&w=400&auto=format&fit=crop'],
                    ['title' => 'بحيرة بيرا', 'image' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=400&auto=format&fit=crop']
                ]
            ],
            [
                'name' => 'نوارا إليا',
                'label' => 'إنجلترا الصغيرة',
                'province_id' => $central->id,
                'description' => 'تشتهر بمناخها البارد ومزارع الشاي والشلالات الساحرة ، وهي المهرب المثالي من حرارة الصيف.',
                'image' => 'https://images.unsplash.com/photo-1542478642-169571343ad8?q=80&w=800&auto=format&fit=crop',
                'attractions' => [
                    ['title' => 'بحيرة غريغوري', 'image' => 'https://images.unsplash.com/photo-1550133730-6922ecd66e8f?q=80&w=400&auto=format&fit=crop'],
                    ['title' => 'شلالات ديفون', 'image' => 'https://images.unsplash.com/photo-1593361099195-20155b413158?q=80&w=400&auto=format&fit=crop']
                ]
            ],
            [
                'name' => 'جالي',
                'label' => 'القلعة التاريخية',
                'province_id' => $southern->id,
                'description' => 'مدينة ساحلية تاريخية مع قلعة هولندية مبنية على شبه جزيرة ، تمنحك إطلالات بحرية لا تنسى.',
                'image' => 'https://images.unsplash.com/photo-1596280453303-3168b55502f1?q=80&w=800&auto=format&fit=crop',
                'attractions' => [
                    ['title' => 'قلعة جالي', 'image' => 'https://images.unsplash.com/photo-1620317375271-9c60953a9985?q=80&w=400&auto=format&fit=crop'],
                    ['title' => 'منارة جالي', 'image' => 'https://images.unsplash.com/photo-1552423814-df0a81124700?q=80&w=400&auto=format&fit=crop']
                ]
            ],
        ];

        foreach ($destinations as $dest) {
            Destination::create($dest);
        }
    }
}
