
@if(isset($errors) and $errors->any())
    <Notification :mtype="'error'" :messages='@json($errors->all())'></Notification>
@endif

@if(isset($messages) and $messages->any())
    <Notification :mtype="'error'" :messages='@json($messages->all())'></Notification>
@endif

@if(session()->has('success_message'))
    <Notification :mtype="'success'" :messages='@json([session()->get('success_message')])'></Notification>
@endif
