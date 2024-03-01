<?php

namespace PHPMaker2024\project2;

// Page object
$DecisionsEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fdecisionsedit" id="fdecisionsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { decisions: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fdecisionsedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fdecisionsedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["decisionDate", [fields.decisionDate.visible && fields.decisionDate.required ? ew.Validators.required(fields.decisionDate.caption) : null, ew.Validators.datetime(fields.decisionDate.clientFormatPattern)], fields.decisionDate.isInvalid],
            ["Decisiontype", [fields.Decisiontype.visible && fields.Decisiontype.required ? ew.Validators.required(fields.Decisiontype.caption) : null], fields.Decisiontype.isInvalid],
            ["kistype", [fields.kistype.visible && fields.kistype.required ? ew.Validators.required(fields.kistype.caption) : null], fields.kistype.isInvalid],
            ["ez", [fields.ez.visible && fields.ez.required ? ew.Validators.required(fields.ez.caption) : null], fields.ez.isInvalid],
            ["chilot", [fields.chilot.visible && fields.chilot.required ? ew.Validators.required(fields.chilot.caption) : null], fields.chilot.isInvalid],
            ["Description", [fields.Description.visible && fields.Description.required ? ew.Validators.required(fields.Description.caption) : null], fields.Description.isInvalid],
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
            "Decisiontype": <?= $Page->Decisiontype->toClientList($Page) ?>,
            "kistype": <?= $Page->kistype->toClientList($Page) ?>,
            "ez": <?= $Page->ez->toClientList($Page) ?>,
            "chilot": <?= $Page->chilot->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="decisions">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->decisionDate->Visible) { // decisionDate ?>
    <div id="r_decisionDate"<?= $Page->decisionDate->rowAttributes() ?>>
        <label id="elh_decisions_decisionDate" for="x_decisionDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->decisionDate->caption() ?><?= $Page->decisionDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->decisionDate->cellAttributes() ?>>
<span id="el_decisions_decisionDate">
<input type="<?= $Page->decisionDate->getInputTextType() ?>" name="x_decisionDate" id="x_decisionDate" data-table="decisions" data-field="x_decisionDate" value="<?= $Page->decisionDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->decisionDate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->decisionDate->formatPattern()) ?>"<?= $Page->decisionDate->editAttributes() ?> aria-describedby="x_decisionDate_help">
<?= $Page->decisionDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->decisionDate->getErrorMessage() ?></div>
<?php if (!$Page->decisionDate->ReadOnly && !$Page->decisionDate->Disabled && !isset($Page->decisionDate->EditAttrs["readonly"]) && !isset($Page->decisionDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdecisionsedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdecisionsedit", "x_decisionDate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Decisiontype->Visible) { // Decisiontype ?>
    <div id="r_Decisiontype"<?= $Page->Decisiontype->rowAttributes() ?>>
        <label id="elh_decisions_Decisiontype" for="x_Decisiontype" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Decisiontype->caption() ?><?= $Page->Decisiontype->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Decisiontype->cellAttributes() ?>>
<span id="el_decisions_Decisiontype">
    <select
        id="x_Decisiontype"
        name="x_Decisiontype"
        class="form-select ew-select<?= $Page->Decisiontype->isInvalidClass() ?>"
        <?php if (!$Page->Decisiontype->IsNativeSelect) { ?>
        data-select2-id="fdecisionsedit_x_Decisiontype"
        <?php } ?>
        data-table="decisions"
        data-field="x_Decisiontype"
        data-value-separator="<?= $Page->Decisiontype->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Decisiontype->getPlaceHolder()) ?>"
        <?= $Page->Decisiontype->editAttributes() ?>>
        <?= $Page->Decisiontype->selectOptionListHtml("x_Decisiontype") ?>
    </select>
    <?= $Page->Decisiontype->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Decisiontype->getErrorMessage() ?></div>
<?= $Page->Decisiontype->Lookup->getParamTag($Page, "p_x_Decisiontype") ?>
<?php if (!$Page->Decisiontype->IsNativeSelect) { ?>
<script>
loadjs.ready("fdecisionsedit", function() {
    var options = { name: "x_Decisiontype", selectId: "fdecisionsedit_x_Decisiontype" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdecisionsedit.lists.Decisiontype?.lookupOptions.length) {
        options.data = { id: "x_Decisiontype", form: "fdecisionsedit" };
    } else {
        options.ajax = { id: "x_Decisiontype", form: "fdecisionsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.decisions.fields.Decisiontype.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kistype->Visible) { // kistype ?>
    <div id="r_kistype"<?= $Page->kistype->rowAttributes() ?>>
        <label id="elh_decisions_kistype" for="x_kistype" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kistype->caption() ?><?= $Page->kistype->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kistype->cellAttributes() ?>>
<span id="el_decisions_kistype">
    <select
        id="x_kistype"
        name="x_kistype"
        class="form-select ew-select<?= $Page->kistype->isInvalidClass() ?>"
        <?php if (!$Page->kistype->IsNativeSelect) { ?>
        data-select2-id="fdecisionsedit_x_kistype"
        <?php } ?>
        data-table="decisions"
        data-field="x_kistype"
        data-value-separator="<?= $Page->kistype->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->kistype->getPlaceHolder()) ?>"
        <?= $Page->kistype->editAttributes() ?>>
        <?= $Page->kistype->selectOptionListHtml("x_kistype") ?>
    </select>
    <?= $Page->kistype->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->kistype->getErrorMessage() ?></div>
<?= $Page->kistype->Lookup->getParamTag($Page, "p_x_kistype") ?>
<?php if (!$Page->kistype->IsNativeSelect) { ?>
<script>
loadjs.ready("fdecisionsedit", function() {
    var options = { name: "x_kistype", selectId: "fdecisionsedit_x_kistype" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdecisionsedit.lists.kistype?.lookupOptions.length) {
        options.data = { id: "x_kistype", form: "fdecisionsedit" };
    } else {
        options.ajax = { id: "x_kistype", form: "fdecisionsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.decisions.fields.kistype.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ez->Visible) { // ez ?>
    <div id="r_ez"<?= $Page->ez->rowAttributes() ?>>
        <label id="elh_decisions_ez" for="x_ez" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ez->caption() ?><?= $Page->ez->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ez->cellAttributes() ?>>
<span id="el_decisions_ez">
    <select
        id="x_ez"
        name="x_ez"
        class="form-select ew-select<?= $Page->ez->isInvalidClass() ?>"
        <?php if (!$Page->ez->IsNativeSelect) { ?>
        data-select2-id="fdecisionsedit_x_ez"
        <?php } ?>
        data-table="decisions"
        data-field="x_ez"
        data-value-separator="<?= $Page->ez->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ez->getPlaceHolder()) ?>"
        <?= $Page->ez->editAttributes() ?>>
        <?= $Page->ez->selectOptionListHtml("x_ez") ?>
    </select>
    <?= $Page->ez->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ez->getErrorMessage() ?></div>
<?= $Page->ez->Lookup->getParamTag($Page, "p_x_ez") ?>
<?php if (!$Page->ez->IsNativeSelect) { ?>
<script>
loadjs.ready("fdecisionsedit", function() {
    var options = { name: "x_ez", selectId: "fdecisionsedit_x_ez" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdecisionsedit.lists.ez?.lookupOptions.length) {
        options.data = { id: "x_ez", form: "fdecisionsedit" };
    } else {
        options.ajax = { id: "x_ez", form: "fdecisionsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.decisions.fields.ez.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chilot->Visible) { // chilot ?>
    <div id="r_chilot"<?= $Page->chilot->rowAttributes() ?>>
        <label id="elh_decisions_chilot" for="x_chilot" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chilot->caption() ?><?= $Page->chilot->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->chilot->cellAttributes() ?>>
<span id="el_decisions_chilot">
    <select
        id="x_chilot"
        name="x_chilot"
        class="form-select ew-select<?= $Page->chilot->isInvalidClass() ?>"
        <?php if (!$Page->chilot->IsNativeSelect) { ?>
        data-select2-id="fdecisionsedit_x_chilot"
        <?php } ?>
        data-table="decisions"
        data-field="x_chilot"
        data-value-separator="<?= $Page->chilot->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->chilot->getPlaceHolder()) ?>"
        <?= $Page->chilot->editAttributes() ?>>
        <?= $Page->chilot->selectOptionListHtml("x_chilot") ?>
    </select>
    <?= $Page->chilot->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->chilot->getErrorMessage() ?></div>
<?= $Page->chilot->Lookup->getParamTag($Page, "p_x_chilot") ?>
<?php if (!$Page->chilot->IsNativeSelect) { ?>
<script>
loadjs.ready("fdecisionsedit", function() {
    var options = { name: "x_chilot", selectId: "fdecisionsedit_x_chilot" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fdecisionsedit.lists.chilot?.lookupOptions.length) {
        options.data = { id: "x_chilot", form: "fdecisionsedit" };
    } else {
        options.ajax = { id: "x_chilot", form: "fdecisionsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.decisions.fields.chilot.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <div id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <label id="elh_decisions_Description" for="x_Description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Description->caption() ?><?= $Page->Description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Description->cellAttributes() ?>>
<span id="el_decisions_Description">
<textarea data-table="decisions" data-field="x_Description" name="x_Description" id="x_Description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Description->getPlaceHolder()) ?>"<?= $Page->Description->editAttributes() ?> aria-describedby="x_Description_help"><?= $Page->Description->EditValue ?></textarea>
<?= $Page->Description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <label id="elh_decisions_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->created_at->cellAttributes() ?>>
<span id="el_decisions_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="decisions" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fdecisionsedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fdecisionsedit", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="decisions" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fdecisionsedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fdecisionsedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("decisions");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
