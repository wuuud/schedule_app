<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Page Content -->
        <main class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h1 class="text-center text-lg">{{ $user->name }}さんの明日の予定一覧</h1>

            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">予定まで</th>
                        <th scope="col" class="py-3 px-6">開始</th>
                        <th scope="col" class="py-3 px-6">タイトル</th>
                        <th scope="col" class="py-3 px-6"></th>
                        <th scope="col" class="py-3 px-6"></th>
                        <th scope="col" class="py-3 px-6"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->events as $event)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">{{ $event->start_diff() }}</td>
                            <td class="py-4 px-6">{{ $event->start }}</td>
                            <td class="py-4 px-6">{{ $event->title }}</td>
                            <td class="py-4 px-6"><a href="{{ route('events.show', $event) }}">詳細</a></td>
                            <td class="py-4 px-6"><a href="{{ route('events.edit', $event) }}">編集</a></td>
                            <td class="py-4 px-6">
                                <form action="{{ route('events.destroy', $event) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="削除する"
                                        onclick="if(!confirm('削除しますか？')){return false};">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </div>
</body>

</html>
