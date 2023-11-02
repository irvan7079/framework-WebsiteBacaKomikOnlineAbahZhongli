<nav class="flex flex-row p-8 justify-between items-center bg-yellow-800 z-10 sticky top-0">
    <a href="#" class="basis-1/4">
        <img src="{{ asset('assets/images/Zhongli.png') }}" alt="Logo ZhongLi" class="w-[140px] h-[120px]">
    </a>
    <ul class="flex flex-row gap-12 justify-center basis-1/2 text-white font-bold text-3xl ">
        <li><a href="#">Tentang</a></li>
        <li><a href="#">Daftar Komik</a></li>
        <li><a href="#">Home</a></li>
    </ul>
    <div class="basis-1/4 flex justify-end">
        @include('components.button', ['nama' => 'Login'])
    </div>
</nav>
