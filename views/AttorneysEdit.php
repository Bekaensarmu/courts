<?php

namespace PHPMaker2024\project2;

// Page object
$AttorneysEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fattorneysedit" id="fattorneysedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { attorneys: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fattorneysedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fattorneysedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["attorneyID", [fields.attorneyID.visible && fields.attorneyID.required ? ew.Validators.required(fields.attorneyID.caption) : null], fields.attorneyID.isInvalid],
            ["Name", [fields.Name.visible && fields.Name.required ? ew.Validators.required(fields.Name.caption) : null], fields.Name.isInvalid],
            ["courtType", [fields.courtType.visible && fields.courtType.required ? ew.Validators.required(fields.courtType.caption) : null], fields.courtType.isInvalid],
            ["Address", [fields.Address.visible && fields.Address.required ? ew.Validators.required(fields.Address.caption) : null], fields.Address.isInvalid],
            ["State", [fields.State.visible && fields.State.required ? ew.Validators.required(fields.State.caption) : null], fields.State.isInvalid],
            ["EmpType", [fields.EmpType.visible && fields.EmpType.required ? ew.Validators.required(fields.EmpType.caption) : null], fields.EmpType.isInvalid],
            ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
            ["court_id", [fields.court_id.visible && fields.court_id.required ? ew.Validators.required(fields.court_id.caption) : null], fields.court_id.isInvalid],
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
            "courtType": <?= $Page->courtType->toClientList($Page) ?>,
            "EmpType": <?= $Page->EmpType->toClientList($Page) ?>,
            "court_id": <?= $Page->court_id->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="attorneys">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_attorneys_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_attorneys_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="attorneys" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->attorneyID->Visible) { // attorneyID ?>
    <div id="r_attorneyID"<?= $Page->attorneyID->rowAttributes() ?>>
        <label id="elh_attorneys_attorneyID" for="x_attorneyID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->attorneyID->caption() ?><?= $Page->attorneyID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->attorneyID->cellAttributes() ?>>
<span id="el_attorneys_attorneyID">
<input type="<?= $Page->attorneyID->getInputTextType() ?>" name="x_attorneyID" id="x_attorneyID" data-table="attorneys" data-field="x_attorneyID" value="<?= $Page->attorneyID->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->attorneyID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->attorneyID->formatPattern()) ?>"<?= $Page->attorneyID->editAttributes() ?> aria-describedby="x_attorneyID_help">
<?= $Page->attorneyID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->attorneyID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Name->Visible) { // Name ?>
    <div id="r_Name"<?= $Page->Name->rowAttributes() ?>>
        <label id="elh_attorneys_Name" for="x_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Name->caption() ?><?= $Page->Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Name->cellAttributes() ?>>
<span id="el_attorneys_Name">
<input type="<?= $Page->Name->getInputTextType() ?>" name="x_Name" id="x_Name" data-table="attorneys" data-field="x_Name" value="<?= $Page->Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Name->formatPattern()) ?>"<?= $Page->Name->editAttributes() ?> aria-describedby="x_Name_help">
<?= $Page->Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->courtType->Visible) { // courtType ?>
    <div id="r_courtType"<?= $Page->courtType->rowAttributes() ?>>
        <label id="elh_attorneys_courtType" for="x_courtType" class="<?= $Page->LeftColumnClass ?>"><?= $Page->courtType->caption() ?><?= $Page->courtType->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->courtType->cellAttributes() ?>>
<span id="el_attorneys_courtType">
    <select
        id="x_courtType"
        name="x_courtType"
        class="form-select ew-select<?= $Page->courtType->isInvalidClass() ?>"
        <?php if (!$Page->courtType->IsNativeSelect) { ?>
        data-select2-id="fattorneysedit_x_courtType"
        <?php } ?>
        data-table="attorneys"
        data-field="x_courtType"
        data-value-separator="<?= $Page->courtType->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->courtType->getPlaceHolder()) ?>"
        <?= $Page->courtType->editAttributes() ?>>
        <?= $Page->courtType->selectOptionListHtml("x_courtType") ?>
    </select>
    <?= $Page->courtType->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->courtType->getErrorMessage() ?></div>
<?= $Page->courtType->Lookup->getParamTag($Page, "p_x_courtType") ?>
<?php if (!$Page->courtType->IsNativeSelect) { ?>
<script>
loadjs.ready("fattorneysedit", function() {
    var options = { name: "x_courtType", selectId: "fattorneysedit_x_courtType" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fattorneysedit.lists.courtType?.lookupOptions.length) {
        options.data = { id: "x_courtType", form: "fattorneysedit" };
    } else {
        options.ajax = { id: "x_courtType", form: "fattorneysedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.attorneys.fields.courtType.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
    <div id="r_Address"<?= $Page->Address->rowAttributes() ?>>
        <label id="elh_attorneys_Address" for="x_Address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Address->caption() ?><?= $Page->Address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Address->cellAttributes() ?>>
<span id="el_attorneys_Address">
<input type="<?= $Page->Address->getInputTextType() ?>" name="x_Address" id="x_Address" data-table="attorneys" data-field="x_Address" value="<?= $Page->Address->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Address->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Address->formatPattern()) ?>"<?= $Page->Address->editAttributes() ?> aria-describedby="x_Address_help">
<?= $Page->Address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->State->Visible) { // State ?>
    <div id="r_State"<?= $Page->State->rowAttributes() ?>>
        <label id="elh_attorneys_State" for="x_State" class="<?= $Page->LeftColumnClass ?>"><?= $Page->State->caption() ?><?= $Page->State->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->State->cellAttributes() ?>>
<span id="el_attorneys_State">
<input type="<?= $Page->State->getInputTextType() ?>" name="x_State" id="x_State" data-table="attorneys" data-field="x_State" value="<?= $Page->State->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->State->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->State->formatPattern()) ?>"<?= $Page->State->editAttributes() ?> aria-describedby="x_State_help">
<?= $Page->State->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->State->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->EmpType->Visible) { // EmpType ?>
    <div id="r_EmpType"<?= $Page->EmpType->rowAttributes() ?>>
        <label id="elh_attorneys_EmpType" class="<?= $Page->LeftColumnClass ?>"><?= $Page->EmpType->caption() ?><?= $Page->EmpType->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->EmpType->cellAttributes() ?>>
<span id="el_attorneys_EmpType">
<template id="tp_x_EmpType">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="attorneys" data-field="x_EmpType" name="x_EmpType" id="x_EmpType"<?= $Page->EmpType->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_EmpType" class="ew-item-list"></div>
<selection-list hidden
    id="x_EmpType[]"
    name="x_EmpType[]"
    value="<?= HtmlEncode($Page->EmpType->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_EmpType"
    data-target="dsl_x_EmpType"
    data-repeatcolumn="5"
    class="form-control<?= $Page->EmpType->isInvalidClass() ?>"
    data-table="attorneys"
    data-field="x_EmpType"
    data-value-separator="<?= $Page->EmpType->displayValueSeparatorAttribute() ?>"
    <?= $Page->EmpType->editAttributes() ?>></selection-list>
<?= $Page->EmpType->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->EmpType->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_attorneys_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_attorneys_description">
<textarea data-table="attorneys" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->court_id->Visible) { // court_id ?>
    <div id="r_court_id"<?= $Page->court_id->rowAttributes() ?>>
        <label id="elh_attorneys_court_id" for="x_court_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->court_id->caption() ?><?= $Page->court_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->court_id->cellAttributes() ?>>
<span id="el_attorneys_court_id">
    <select
        id="x_court_id"
        name="x_court_id"
        class="form-select ew-select<?= $Page->court_id->isInvalidClass() ?>"
        <?php if (!$Page->court_id->IsNativeSelect) { ?>
        data-select2-id="fattorneysedit_x_court_id"
        <?php } ?>
        data-table="attorneys"
        data-field="x_court_id"
        data-value-separator="<?= $Page->court_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->court_id->getPlaceHolder()) ?>"
        <?= $Page->court_id->editAttributes() ?>>
        <?= $Page->court_id->selectOptionListHtml("x_court_id") ?>
    </select>
    <?= $Page->court_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->court_id->getErrorMessage() ?></div>
<?= $Page->court_id->Lookup->getParamTag($Page, "p_x_court_id") ?>
<?php if (!$Page->court_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fattorneysedit", function() {
    var options = { name: "x_court_id", selectId: "fattorneysedit_x_court_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fattorneysedit.lists.court_id?.lookupOptions.length) {
        options.data = { id: "x_court_id", form: "fattorneysedit" };
    } else {
        options.ajax = { id: "x_court_id", form: "fattorneysedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.attorneys.fields.court_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <label id="elh_attorneys_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->created_at->cellAttributes() ?>>
<span id="el_attorneys_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="attorneys" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fattorneysedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fattorneysedit", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fattorneysedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fattorneysedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("attorneys");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
