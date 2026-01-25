<div class="w-full mx-auto">
    <div class="flex justify-between items-start mb-10">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-2 h-10 bg-indigo-600 rounded-full"></div> <?= __("Manage Post") ?>
            </h1>
            <p class="mt-2 text-slate-500 font-medium max-w-xl">
                <?= __("Create, edit, and manage all your website content here. Use categories and status to organize your publications.") ?>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button id="btnBulkDelete" type="button" class="hidden bg-rose-50 hover:bg-rose-100 text-rose-600 px-6 py-4 rounded-custom font-black text-xs tracking-widest border border-rose-200 transition-all flex items-center gap-2 shadow-sm">
                <?= __("DELETE SELECTED") ?> (<span id="countCheck">0</span>)
            </button>
            <button id="btn-create" class="px-8 py-4 bg-slate-900 text-white rounded-custom font-black text-xs tracking-widest hover:bg-indigo-600 transition-all shadow-xl">
                + <?= __("CREATE NEW POST") ?>
            </button>
        </div>
    </div>

    <div class="bg-white p-5 rounded-custom border border-slate-200 mb-6 shadow-sm">
        <form action="" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="<?= __("Search post title...") ?>" class="w-full pl-4 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-medium">
            </div>
            <select name="filter_cat" class="w-full md:w-56 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500">
                <option value=""><?= __("All Categories") ?></option>
                <option value="berita" <?= ($filter_cat ?? '') == 'berita' ? 'selected' : '' ?>><?= __("News") ?></option>
                <option value="artikel" <?= ($filter_cat ?? '') == 'artikel' ? 'selected' : '' ?>><?= __("Article") ?></option>
                <option value="informasi" <?= ($filter_cat ?? '') == 'informasi' ? 'selected' : '' ?>><?= __("Information") ?></option>
            </select>
            <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-600 transition-colors shadow-md text-xs tracking-widest">
                <?= __("FILTER") ?>
            </button>
        </form>
    </div>

    <form id="formBulkDelete" action="<?= BASE_URL ?>/admin/post/bulkdelete" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="bg-white rounded-custom border border-slate-200 overflow-hidden shadow-sm">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] border-b">
                    <tr>
                        <th class="p-6 w-10">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="p-6"><?= __("POST INFORMATION") ?></th>
                        <th class="p-6"><?= __("CATEGORY") ?></th>
                        <th class="p-6 text-center"><?= __("STATUS") ?></th>
                        <th class="p-6 text-right"><?= __("ACTIONS") ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(empty($posts)): ?>
                        <tr>
                            <td colspan="5" class="p-20 text-center text-slate-400 font-medium italic">
                                <?= __("No data found.") ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($posts as $row): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-6">
                            <input type="checkbox" name="ids[]" value="<?= $row['id'] ?>" class="itemCheckbox w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-12 rounded-lg overflow-hidden border border-slate-200 shadow-sm bg-slate-100 flex-shrink-0">
                                    <?= $asset::render_image($row['gambar'], "w-full h-full object-cover") ?>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-800 leading-snug"><?= $row['judul'] ?></h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider italic">
                                            <?= date('d M Y', strtotime($row['tanggal_dibuat'])) ?>
                                        </p>
                                        <span class="text-slate-300">|</span>
                                        <p class="text-[10px] text-indigo-500 font-bold uppercase tracking-wider">
                                            BY: <?= $row['author'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-6">
                             <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase bg-indigo-50 text-indigo-600 border border-indigo-100 italic">
                                <?= $row['kategori'] ?>
                            </span>
                        </td>
                        <td class="p-6 text-center">
                            <span class="px-3 py-1.5 <?= $row['status'] == 'publish' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-200' ?> text-[9px] font-black uppercase rounded-lg border shadow-sm">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td class="p-6 text-right flex justify-end gap-2">
                            <button type="button" class="btn-edit p-2 border rounded-custom hover:text-indigo-600 transition-all text-slate-400" 
                                    data-json='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>'>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <a href="<?= BASE_URL ?>/admin/post/delete/<?= $row['id'] ?>" onclick="return confirm('<?= __("Are you sure?") ?>')" class="p-2 border rounded-custom hover:text-red-600 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>

    <?php if(($total_hal ?? 0) > 1): ?>
    <div class="mt-8 flex justify-center items-center gap-2">
        <?php for($i=1; $i<=$total_hal; $i++): ?>
            <a href="?halaman=<?= $i ?>&search=<?= urlencode($search) ?>&filter_cat=<?= $filter_cat ?>" class="w-10 h-10 flex items-center justify-center rounded-xl font-bold transition-all <?= $halaman == $i ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<div id="modal-post" class="fixed inset-0 z-[999] overflow-y-auto flex items-center justify-center p-4" style="display: none;">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm modal-overlay"></div>
    <div class="relative bg-white w-full max-w-6xl rounded-custom shadow-2xl overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center bg-slate-50">
            <h3 id="modal-title" class="font-black text-slate-800 uppercase tracking-widest text-sm"></h3>
            <button type="button" class="btn-close text-slate-400 text-2xl hover:text-rose-600 transition-colors">&times;</button>
        </div>
        
        <form id="contentForm" action="<?= BASE_URL ?>/admin/post/save" method="POST" enctype="multipart/form-data" class="p-8">
            <input type="hidden" name="post_id" id="input-id">
            <input type="hidden" name="old_gambar" id="input-old-gambar">
            <input type="hidden" name="csrf_token" id="csrf_token_input" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-12 lg:col-span-8 space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase block mb-2 tracking-widest"><?= __("Post Title") ?></label>
                        <input type="text" name="judul" id="input-judul" required class="w-full bg-slate-50 border rounded-custom px-4 py-4 text-sm font-bold outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase block mb-2 tracking-widest"><?= __("Tags (comma separated)") ?></label>
                        <input type="text" name="tags" id="input-tags" placeholder="e.g. news, library, education" class="w-full bg-slate-50 border rounded-custom px-4 py-4 text-sm font-bold outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase block mb-2 tracking-widest"><?= __("Content") ?></label>
                        <div id="toolbar-container" class="border border-slate-200 bg-slate-50"></div>
                        <div class="border border-slate-200 border-t-0 bg-white">
                            <div id="editor-editable" class="p-8 min-h-[450px] prose max-w-none focus:outline-none"></div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-4 space-y-6">
                    <div class="p-6 bg-slate-50 rounded-custom border border-slate-200 space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase block mb-2 tracking-widest"><?= __("Status") ?></label>
                            <select name="status_post" id="input-status" class="w-full p-3 bg-white border rounded-xl font-bold outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="publish"><?= __("Publish") ?></option>
                                <option value="draft"><?= __("Draft") ?></option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase block mb-2 tracking-widest"><?= __("Category") ?></label>
                            <select name="kategori" id="input-kategori" class="w-full p-3 bg-white border rounded-xl font-bold outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="berita"><?= __("News") ?></option>
                                <option value="artikel"><?= __("Article") ?></option>
                                <option value="informasi"><?= __("Information") ?></option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase block mb-2 tracking-widest"><?= __("Cover Image") ?></label>
                            <div id="preview-box" class="hidden mb-4 rounded-xl overflow-hidden border-2 border-dashed border-slate-300 bg-white aspect-video relative group shadow-sm">
                                <img id="img-prev" class="w-full h-full object-cover">
                            </div>
                            <input type="file" name="gambar" id="f_gambar" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white hover:file:bg-indigo-600 cursor-pointer">
                        </div>
                    </div>
                    <button type="submit" class="w-full px-12 py-5 bg-indigo-600 text-white rounded-custom font-black uppercase text-xs tracking-[0.2em] shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95">
                        <?= __("SAVE POST DATA") ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let editorInstance;
function decodeHtml(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

class MyUploadAdapter {
    constructor(loader) { this.loader = loader; }
    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            if (!file.type.startsWith('image/')) return reject('<?= __("Only image files are allowed.") ?>');
            const data = new FormData();
            data.append('upload', file);
            data.append('post_title', $('#input-judul').val() || 'content');
            data.append('csrf_token', $('#csrf_token_input').val());
            $.ajax({
                url: '<?= BASE_URL ?>/admin/post/uploadImageEditor',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: res => res.uploaded ? resolve({default: res.url}) : reject(res.error.message),
                error: () => reject('<?= __("Failed to upload image.") ?>')
            });
        }));
    }
}

$(document).ready(function() {
    if (document.querySelector('#editor-editable')) {
        DecoupledEditor.create(document.querySelector('#editor-editable'), {
            extraPlugins: [ function(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => new MyUploadAdapter(loader);
            }]
        }).then(editor => {
            document.querySelector('#toolbar-container').appendChild(editor.ui.view.toolbar.element);
            editorInstance = editor;
        }).catch(error => console.error(error));
    }

    window.openModal = function(data = null) {
        if (data) {
            $('#modal-title').text('<?= __("Edit Existing Post") ?>');
            $('#input-id').val(data.id);
            $('#input-old-gambar').val(data.gambar);
            $('#input-judul').val(decodeHtml(data.judul));
            $('#input-tags').val(data.tags || '');
            $('#input-kategori').val(data.kategori);
            $('#input-status').val(data.status);
            if (editorInstance) editorInstance.setData(data.isi || '');
            if (data.gambar) {
                $('#img-prev').attr('src', '<?= BASE_URL ?>/assets/img/posts/' + data.gambar);
                $('#preview-box').removeClass('hidden');
            } else {
                $('#preview-box').addClass('hidden');
            }
        } else {
            $('#modal-title').text('<?= __("CREATE NEW POST") ?>');
            $('#contentForm')[0].reset();
            $('#input-id').val('');
            $('#input-old-gambar').val('');
            $('#input-tags').val('');
            if (editorInstance) editorInstance.setData('');
            $('#preview-box').addClass('hidden');
        }
        $('#modal-post').css('display', 'flex').hide().fadeIn(200);
        $('body').css('overflow', 'hidden');
    }

    $(document).on('click', '.btn-edit', function() { openModal($(this).data('json')); });
    $('#btn-create').on('click', () => openModal());
    $('.btn-close, .modal-overlay').on('click', () => {
        $('#modal-post').fadeOut(200);
        $('body').css('overflow', 'auto');
    });

    $('#selectAll').on('change', function() {
        $('.itemCheckbox').prop('checked', this.checked);
        updateBulkButton();
    });

    $(document).on('change', '.itemCheckbox', function() {
        $('#selectAll').prop('checked', $('.itemCheckbox:checked').length === $('.itemCheckbox').length);
        updateBulkButton();
    });

    function updateBulkButton() {
        const count = $('.itemCheckbox:checked').length;
        $('#countCheck').text(count);
        count > 0 ? $('#btnBulkDelete').removeClass('hidden') : $('#btnBulkDelete').addClass('hidden');
    }

    $('#btnBulkDelete').on('click', function() {
        if(confirm('<?= __("Delete selected data?") ?>')) $('#formBulkDelete').submit();
    });

    $('#f_gambar').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                $('#img-prev').attr('src', e.target.result);
                $('#preview-box').removeClass('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    $('#contentForm').on('submit', function() {
        if (editorInstance) {
            const data = editorInstance.getData();
            if ($('textarea[name="isi"]').length === 0) {
                $(this).append('<textarea name="isi" class="hidden">' + data + '</textarea>');
            } else {
                $('textarea[name="isi"]').val(data);
            }
        }
    });
});
</script>