<form action="{{ route('resource-groups.delete', ['group' => $group->id]) }}" method="POST" id="delete-form">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
</form>

<script>
    const deleteRG = () => {
        document.getElementById('delete-form').submit();
    }
</script>