<div class="row">
    <label class="control-label">Ảnh</label>
    <div style="height: 200px; position: relative;">
        <img src="" id="thumb-change-<?php echo $id?>" class="thumb-slider">
        <label for="clip-thumbnail_<?php echo $id?>" class="thumb-slider-change-text">Upload ảnh</label>
        <input type="file" onchange="onFileSelected(event, <?php echo $id?>);" value="image" id="clip-thumbnail_<?php echo $id?>" name="clip_thumbnail_<?php echo $id?>" class="hidden">
    </div>
</div>