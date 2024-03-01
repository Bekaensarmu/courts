<?php

namespace PHPMaker2024\project2;

// Page object
$CourtsEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fcourtsedit" id="fcourtsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { courts: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fcourtsedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcourtsedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["courtID", [fields.courtID.visible && fields.courtID.required ? ew.Validators.required(fields.courtID.caption) : null], fields.courtID.isInvalid],
            ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
            ["workType", [fields.workType.visible && fields.workType.required ? ew.Validators.required(fields.workType.caption) : null], fields.workType.isInvalid],
            ["yetefekedebizat", [fields.yetefekedebizat.visible && fields.yetefekedebizat.required ? ew.Validators.required(fields.yetefekedebizat.caption) : null, ew.Validators.integer], fields.yetefekedebizat.isInvalid],
            ["yale", [fields.yale.visible && fields.yale.required ? ew.Validators.required(fields.yale.caption) : null, ew.Validators.integer], fields.yale.isInvalid],
            ["yegodele", [fields.yegodele.visible && fields.yegodele.required ? ew.Validators.required(fields.yegodele.caption) : null, ew.Validators.integer], fields.yegodele.isInvalid],
            ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
            ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(fields.created_at.clientFormatPattern)], fields.created_at.isInvalid],
            ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null], fields.updated_at.isInvalid],
            ["updated_by", [fields.updated_by.visible && fields.updated_by.required ? ew.Validators.required(fields.updated_by.caption) : null], fields.updated_by.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="courts">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->courtID->Visible) { // courtID ?>
    <div id="r_courtID"<?= $Page->courtID->rowAttributes() ?>>
        <label id="elh_courts_courtID" for="x_courtID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->courtID->caption() ?><?= $Page->courtID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->courtID->cellAttributes() ?>>
<span id="el_courts_courtID">
<input type="<?= $Page->courtID->getInputTextType() ?>" name="x_courtID" id="x_courtID" data-table="courts" data-field="x_courtID" value="<?= $Page->courtID->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->courtID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->courtID->formatPattern()) ?>"<?= $Page->courtID->editAttributes() ?> aria-describedby="x_courtID_help">
<?= $Page->courtID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->courtID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_courts_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_courts_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="courts" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name->formatPattern()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->workType->Visible) { // workType ?>
    <div id="r_workType"<?= $Page->workType->rowAttributes() ?>>
        <label id="elh_courts_workType" for="x_workType" class="<?= $Page->LeftColumnClass ?>"><?= $Page->workType->caption() ?><?= $Page->workType->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->workType->cellAttributes() ?>>
<span id="el_courts_workType">
<input type="<?= $Page->workType->getInputTextType() ?>" name="x_workType" id="x_workType" data-table="courts" data-field="x_workType" value="<?= $Page->workType->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->workType->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->workType->formatPattern()) ?>"<?= $Page->workType->editAttributes() ?> aria-describedby="x_workType_help">
<?= $Page->workType->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->workType->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->yetefekedebizat->Visible) { // yetefekedebizat ?>
    <div id="r_yetefekedebizat"<?= $Page->yetefekedebizat->rowAttributes() ?>>
        <label id="elh_courts_yetefekedebizat" for="x_yetefekedebizat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->yetefekedebizat->caption() ?><?= $Page->yetefekedebizat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->yetefekedebizat->cellAttributes() ?>>
<span id="el_courts_yetefekedebizat">
<input type="<?= $Page->yetefekedebizat->getInputTextType() ?>" name="x_yetefekedebizat" id="x_yetefekedebizat" data-table="courts" data-field="x_yetefekedebizat" value="<?= $Page->yetefekedebizat->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->yetefekedebizat->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->yetefekedebizat->formatPattern()) ?>"<?= $Page->yetefekedebizat->editAttributes() ?> aria-describedby="x_yetefekedebizat_help">
<?= $Page->yetefekedebizat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->yetefekedebizat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->yale->Visible) { // yale ?>
    <div id="r_yale"<?= $Page->yale->rowAttributes() ?>>
        <label id="elh_courts_yale" for="x_yale" class="<?= $Page->LeftColumnClass ?>"><?= $Page->yale->caption() ?><?= $Page->yale->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->yale->cellAttributes() ?>>
<span id="el_courts_yale">
<input type="<?= $Page->yale->getInputTextType() ?>" name="x_yale" id="x_yale" data-table="courts" data-field="x_yale" value="<?= $Page->yale->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->yale->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->yale->formatPattern()) ?>"<?= $Page->yale->editAttributes() ?> aria-describedby="x_yale_help">
<?= $Page->yale->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->yale->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->yegodele->Visible) { // yegodele ?>
    <div id="r_yegodele"<?= $Page->yegodele->rowAttributes() ?>>
        <label id="elh_courts_yegodele" for="x_yegodele" class="<?= $Page->LeftColumnClass ?>"><?= $Page->yegodele->caption() ?><?= $Page->yegodele->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->yegodele->cellAttributes() ?>>
<span id="el_courts_yegodele">
<input type="<?= $Page->yegodele->getInputTextType() ?>" name="x_yegodele" id="x_yegodele" data-table="courts" data-field="x_yegodele" value="<?= $Page->yegodele->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->yegodele->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->yegodele->formatPattern()) ?>"<?= $Page->yegodele->editAttributes() ?> aria-describedby="x_yegodele_help">
<?= $Page->yegodele->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->yegodele->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_courts_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_courts_description">
<textarea data-table="courts" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <label id="elh_courts_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->created_at->cellAttributes() ?>>
<span id="el_courts_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="courts" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcourtsedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fcourtsedit", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="courts" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcourtsedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcourtsedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("courts");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
