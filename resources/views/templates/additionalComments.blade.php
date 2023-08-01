@foreach ($comments as $comment)
    <!-- Включение шаблона для отображения комментария -->
    @include('templates/comment', ['comment' => $comment, 'canReply' => Auth::check(), 'displayChildComments' => true])
@endforeach
