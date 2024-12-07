@php
    // Define translations for both languages
    $translations = [
        'en' => [
            'title' => 'VISION - MISSION OF YODY',
            'intro' =>
                'Starting from the Hi5 fashion brand founded in 2009, after overcoming many challenges, Hi5 was renamed to Yody in 2014 with the dream of building a leading global fashion brand.',
            'growth' =>
                'Since then, Yody has grown rapidly. By 2016, Yody had 38 stores. Just two years later, in 2018, Yody expanded to 73 stores, and by 2019, the number reached 82. Currently, Yody has over 260 stores nationwide.',
            'mission' => 'Make everyone look good, feel good',
            'vision' => 'Everyday wear for everyone',
            'beliefs' => [
                'All expenses are costs, except those spent on customers and employees.',
                'All members of Yody are striving and capable of achieving the common goal.',
                'Each Yody member can change when given trust, recognition, guidance, and training.',
            ],
            'core_values' => [
                'Customer centric' => 'Put customer satisfaction as the top priority in all thoughts and actions.',
                'Ownership & Autonomy' =>
                    'Own the company, team, and individual goals. Be proactive in seeking resources and solutions.',
                'Integrity' =>
                    'Be honest about money, goods, and assets. Keep promises to customers, colleagues, and partners.',
                'Growth mindset' => 'Always learning and developing. Accept failures as lessons.',
                'Good relationship' =>
                    'Be friendly, generous, and care about the success of others. Create an open, friendly, and united work environment.',
            ],
            'journey' => [
                '2014' => 'Open the first store and subsequent ones.',
                '2015' => 'Find a new office and have 12 stores.',
                '2016' => 'Expand to 38 stores and enter Hanoi.',
                '2018' => 'Have 73 stores and improve product quality.',
                '2020' => 'Take Yody global and open the largest store in Southeast Asia.',
            ],
        ],
        'vi' => [
            'title' => 'TẦM NHÌN - SỨ MỆNH YODY',
            'intro' =>
                'Bắt đầu từ thương hiệu thời trang Hi5 ra đời trong năm 2009, trải qua chặng đường phát triển đầy khó khăn, Hi5 được đổi tên thành Yody vào năm 2014 với ước mơ gây dựng một thương hiệu thời trang hàng đầu thế giới.',
            'growth' =>
                'Từ đó, Yody lớn mạnh không ngừng. Đến năm 2016, Yody đã có 38 cửa hàng. Chỉ sau 2 năm, vào năm 2018, Yody đã mở rộng lên 73 cửa hàng, và đến năm 2019, con số này đã lên tới 82. Tính đến hiện tại, Yody đã có hơn 260 cửa hàng trên toàn quốc.',
            'mission' => 'Make everyone look good, feel good',
            'vision' => 'Everyday wear for everyone',
            'beliefs' => [
                'Tất cả các khoản chi đều là chi phí, chỉ có chi cho khách hàng và nhân viên là không phí.',
                'Tất cả những thành viên của Yody đều đang nỗ lực hết sức và có năng lực để thực hiện mục tiêu chung.',
                'Mỗi thành viên Yody đều có thể thay đổi khi được trao niềm tin, ghi nhận, hướng dẫn và đào tạo.',
            ],
            'core_values' => [
                'Customer centric' => 'Đặt sự hài lòng của khách hàng là ưu tiên số 1 trong mọi suy nghĩ và hành động.',
                'Ownership & Autonomy' =>
                    'Sở hữu mục tiêu công ty, đội nhóm, cá nhân. Chủ động tìm kiếm nguồn lực và giải pháp.',
                'Integrity' =>
                    'Trung thực về tiền bạc, hàng hóa, tài sản. Giữ lời hứa với khách hàng, đồng nghiệp, đối tác.',
                'Growth mindset' => 'Không ngừng học hỏi và phát triển. Chấp nhận thất bại để học hỏi.',
                'Good relationship' =>
                    'Thân thiện, hào phóng, quan tâm đến sự thành công của người khác. Tạo môi trường làm việc cởi mở, thân thiện, đoàn kết.',
            ],
            'journey' => [
                '2014' => 'Khai trương cửa hàng đầu tiên và các cửa hàng tiếp theo.',
                '2015' => 'Tìm văn phòng mới và có 12 cửa hàng.',
                '2016' => 'Mở rộng đến 38 cửa hàng và bước vào Hà Nội.',
                '2018' => 'Có 73 cửa hàng và nâng tầm chất lượng sản phẩm.',
                '2020' => 'Đưa Yody ra thế giới và khai trương cửa hàng lớn nhất Đông Nam Á.',
            ],
        ],
    ];
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get selected language translation
    $selectedLangData = $translations[$locale] ?? $translations['vi']; // Default to Vietnamese
@endphp
@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-16 lg:py-32 px-4">
        <div class="relative pb-11">
            <div id="yody-page-info-content" class="max-w-4xl mx-auto">
                <div class="space-y-6 text-gray-700">
                    <h1 class="text-4xl font-bold text-center text-indigo-900 leading-tight fade-in">
                        {{ $selectedLangData['title'] }}</h1>
                    <p class="text-lg text-justify mt-6 italic fade-in">
                        <strong>{{ $selectedLangData['intro'] }}</strong>
                    </p>
                    <p class="text-lg text-justify fade-in">{{ $selectedLangData['growth'] }}</p>
                    <div class="flex justify-center fade-in">
                        <img class="rounded-lg shadow-lg max-w-full h-auto"
                            src="//bizweb.dktcdn.net/100/438/408/files/su-menh-tam-nhin-yodyvn.jpg?v=1668418669422"
                            alt="Sứ mệnh và tầm nhìn YODY">
                    </div>

                    <h2 class="text-2xl font-bold text-indigo-900 mt-8">{{ $selectedLangData['mission'] }}</h2>
                    <p class="text-lg text-gray-700">{{ $selectedLangData['mission'] }}</p>

                    <h2 class="text-2xl font-bold text-indigo-900 mt-8">{{ $selectedLangData['vision'] }}</h2>
                    <p class="text-lg text-gray-700">{{ $selectedLangData['vision'] }}</p>
                    <ul class="list-disc list-inside text-lg space-y-3">
                        @foreach ($selectedLangData['beliefs'] as $belief)
                            <li>{{ $belief }}</li>
                        @endforeach
                    </ul>

                    <div class="flex justify-center my-10">
                        <img class="rounded-lg shadow-lg max-w-full h-auto"
                            src="//bizweb.dktcdn.net/100/438/408/files/tam-nhin-su-menh-yody.jpg?v=1708662665859"
                            alt="Tầm nhìn sứ mệnh YODY">
                    </div>

                    <p class="text-lg text-justify">{{ $selectedLangData['intro'] }}</p>
                    @foreach ($selectedLangData['core_values'] as $core_value => $description)
                        <h3 class="text-xl font-bold text-indigo-800 mt-6">{{ $core_value }}</h3>
                        <p class="text-lg">{{ $description }}</p>
                    @endforeach
                    <ul class="list-none space-y-3 text-lg">
                        @foreach ($selectedLangData['journey'] as $year => $event)
                            <li><strong>{{ $year }}</strong>: {{ $event }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
