<?php

namespace PHPMaker2024\project2;

// Page object
$JudgesAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { judges: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fjudgesadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fjudgesadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["judgeID", [fields.judgeID.visible && fields.judgeID.required ? ew.Validators.required(fields.judgeID.caption) : null], fields.judgeID.isInvalid],
            ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
            ["courtTyep", [fields.courtTyep.visible && fields.courtTyep.required ? ew.Validators.required(fields.courtTyep.caption) : null], fields.courtTyep.isInvalid],
            ["Address", [fields.Address.visible && fields.Address.required ? ew.Validators.required(fields.Address.caption) : null], fields.Address.isInvalid],
            ["state", [fields.state.visible && fields.state.required ? ew.Validators.required(fields.state.caption) : null], fields.state.isInvalid],
            ["Emptype", [fields.Emptype.visible && fields.Emptype.required ? ew.Validators.required(fields.Emptype.caption) : null], fields.Emptype.isInvalid],
            ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
            ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(fields.created_at.clientFormatPattern)], fields.created_at.isInvalid]
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
            "courtTyep": <?= $Page->courtTyep->toClientList($Page) ?>,
            "Emptype": <?= $Page->Emptype->toClientList($Page) ?>,
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fjudgesadd" id="fjudgesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="judges">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->judgeID->Visible) { // judgeID ?>
    <div id="r_judgeID"<?= $Page->judgeID->rowAttributes() ?>>
        <label id="elh_judges_judgeID" for="x_judgeID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->judgeID->caption() ?><?= $Page->judgeID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->judgeID->cellAttributes() ?>>
<span id="el_judges_judgeID">
<input type="<?= $Page->judgeID->getInputTextType() ?>" name="x_judgeID" id="x_judgeID" data-table="judges" data-field="x_judgeID" value="<?= $Page->judgeID->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->judgeID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->judgeID->formatPattern()) ?>"<?= $Page->judgeID->editAttributes() ?> aria-describedby="x_judgeID_help">
<?= $Page->judgeID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->judgeID->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_judges_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_judges_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="judges" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name->formatPattern()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->courtTyep->Visible) { // courtTyep ?>
    <div id="r_courtTyep"<?= $Page->courtTyep->rowAttributes() ?>>
        <label id="elh_judges_courtTyep" for="x_courtTyep" class="<?= $Page->LeftColumnClass ?>"><?= $Page->courtTyep->caption() ?><?= $Page->courtTyep->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->courtTyep->cellAttributes() ?>>
<span id="el_judges_courtTyep">
    <select
        id="x_courtTyep"
        name="x_courtTyep"
        class="form-select ew-select<?= $Page->courtTyep->isInvalidClass() ?>"
        <?php if (!$Page->courtTyep->IsNativeSelect) { ?>
        data-select2-id="fjudgesadd_x_courtTyep"
        <?php } ?>
        data-table="judges"
        data-field="x_courtTyep"
        data-value-separator="<?= $Page->courtTyep->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->courtTyep->getPlaceHolder()) ?>"
        <?= $Page->courtTyep->editAttributes() ?>>
        <?= $Page->courtTyep->selectOptionListHtml("x_courtTyep") ?>
    </select>
    <?= $Page->courtTyep->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->courtTyep->getErrorMessage() ?></div>
<?= $Page->courtTyep->Lookup->getParamTag($Page, "p_x_courtTyep") ?>
<?php if (!$Page->courtTyep->IsNativeSelect) { ?>
<script>
loadjs.ready("fjudgesadd", function() {
    var options = { name: "x_courtTyep", selectId: "fjudgesadd_x_courtTyep" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fjudgesadd.lists.courtTyep?.lookupOptions.length) {
        options.data = { id: "x_courtTyep", form: "fjudgesadd" };
    } else {
        options.ajax = { id: "x_courtTyep", form: "fjudgesadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.judges.fields.courtTyep.selectOptions);
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
        <label id="elh_judges_Address" for="x_Address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Address->caption() ?><?= $Page->Address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Address->cellAttributes() ?>>
<span id="el_judges_Address">
<input type="<?= $Page->Address->getInputTextType() ?>" name="x_Address" id="x_Address" data-table="judges" data-field="x_Address" value="<?= $Page->Address->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Address->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Address->formatPattern()) ?>"<?= $Page->Address->editAttributes() ?> aria-describedby="x_Address_help">
<?= $Page->Address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
    <div id="r_state"<?= $Page->state->rowAttributes() ?>>
        <label id="elh_judges_state" for="x_state" class="<?= $Page->LeftColumnClass ?>"><?= $Page->state->caption() ?><?= $Page->state->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->state->cellAttributes() ?>>
<span id="el_judges_state">
<input type="<?= $Page->state->getInputTextType() ?>" name="x_state" id="x_state" data-table="judges" data-field="x_state" value="<?= $Page->state->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->state->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->state->formatPattern()) ?>"<?= $Page->state->editAttributes() ?> aria-describedby="x_state_help">
<?= $Page->state->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->state->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Emptype->Visible) { // Emptype ?>
    <div id="r_Emptype"<?= $Page->Emptype->rowAttributes() ?>>
        <label id="elh_judges_Emptype" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Emptype->caption() ?><?= $Page->Emptype->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Emptype->cellAttributes() ?>>
<span id="el_judges_Emptype">
<template id="tp_x_Emptype">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="judges" data-field="x_Emptype" name="x_Emptype" id="x_Emptype"<?= $Page->Emptype->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_Emptype" class="ew-item-list"></div>
<selection-list hidden
    id="x_Emptype"
    name="x_Emptype"
    value="<?= HtmlEncode($Page->Emptype->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_Emptype"
    data-target="dsl_x_Emptype"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Emptype->isInvalidClass() ?>"
    data-table="judges"
    data-field="x_Emptype"
    data-value-separator="<?= $Page->Emptype->displayValueSeparatorAttribute() ?>"
    <?= $Page->Emptype->editAttributes() ?>></selection-list>
<?= $Page->Emptype->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Emptype->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_judges_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_judges_description">
<textarea data-table="judges" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <label id="elh_judges_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->created_at->cellAttributes() ?>>
<span id="el_judges_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="judges" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fjudgesadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fjudgesadd", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fjudgesadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fjudgesadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("judges");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
