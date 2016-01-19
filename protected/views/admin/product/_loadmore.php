<div class="row">
    <label class="control-label">Ảnh</label>
    <div style="height: 200px; position: relative;">
        <img src="" id="thumb-change-<?php echo $id?>" class="thumb-slider">
        <label for="clip-thumbnail" class="thumb-slider-change-text">Upload ảnh</label>
        <input type="file" onchange="onFileSelected(event);" value="image" id="clip-thumbnail" name="clip_thumbnail" class="hidden">
    </div>
</div>