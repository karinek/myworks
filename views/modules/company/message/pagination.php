          <ul class="my_contacts_pagination">

                            <li><a href="?page=<?= $pagination['page'] ?>">Last Page</a></li>
                            <li  class="next <?= $pagination['cur'] >= $pagination['page'] ? 'disable' : '' ?>"><a href="<? if ((int) $pagination['cur'] >= (int) $pagination['page']) {
    echo "#";
} else {
    echo "?page=" . ($pagination['cur'] + 1);
} ?>"></a></li>
                            <li  class="prev <?= $pagination['cur'] <= 1 ? 'disable' : '' ?>"><a href="<? if ($pagination['cur'] <= 1) {
    echo '#';
} else {
    echo "?page=" . ($pagination['cur'] - 1);
}; ?>"></a></li>
                            <li>Page <span><?= $pagination['cur'] ?></span> / <?= $pagination['page'] ?></li>
                        </ul>  
  