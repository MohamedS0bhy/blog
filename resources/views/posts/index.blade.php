
<x-layout>

    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        @if(count($posts) > 0)
            <x-post-featured-card :post="$posts[0]"/>

            <div class="lg:grid lg:grid-cols-3">
                @foreach ($posts->skip(1) as $p )
                    <x-post-card :post="$p"/>
                @endforeach
            </div>

        @else
            <div class="danger">There Are No Posts</div>
        @endif

    </main>
</x-layout>
