<?php

namespace PHPMaker2024\project2;

// Page object
$CaseHearsEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fcase_hearsedit" id="fcase_hearsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { case_hears: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fcase_hearsedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcase_hearsedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["melequtir", [fields.melequtir.visible && fields.melequtir.required ? ew.Validators.required(fields.melequtir.caption) : null], fields.melequtir.isInvalid],
            ["RANKe", [fields.RANKe.visible && fields.RANKe.required ? ew.Validators.required(fields.RANKe.caption) : null], fields.RANKe.isInvalid],
            ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
            ["ez", [fields.ez.visible && fields.ez.required ? ew.Validators.required(fields.ez.caption) : null], fields.ez.isInvalid],
            ["fileNumber", [fields.fileNumber.visible && fields.fileNumber.required ? ew.Validators.required(fields.fileNumber.caption) : null], fields.fileNumber.isInvalid],
            ["firdbet", [fields.firdbet.visible && fields.firdbet.required ? ew.Validators.required(fields.firdbet.caption) : null], fields.firdbet.isInvalid],
            ["chilotname", [fields.chilotname.visible && fields.chilotname.required ? ew.Validators.required(fields.chilotname.caption) : null], fields.chilotname.isInvalid],
            ["kirihidet", [fields.kirihidet.visible && fields.kirihidet.required ? ew.Validators.required(fields.kirihidet.caption) : null], fields.kirihidet.isInvalid],
            ["yekisaynet", [fields.yekisaynet.visible && fields.yekisaynet.required ? ew.Validators.required(fields.yekisaynet.caption) : null], fields.yekisaynet.isInvalid],
            ["keteroreason", [fields.keteroreason.visible && fields.keteroreason.required ? ew.Validators.required(fields.keteroreason.caption) : null], fields.keteroreason.isInvalid],
            ["sex", [fields.sex.visible && fields.sex.required ? ew.Validators.required(fields.sex.caption) : null], fields.sex.isInvalid],
            ["tekesashbizat", [fields.tekesashbizat.visible && fields.tekesashbizat.required ? ew.Validators.required(fields.tekesashbizat.caption) : null, ew.Validators.integer], fields.tekesashbizat.isInvalid],
            ["keterodate", [fields.keterodate.visible && fields.keterodate.required ? ew.Validators.required(fields.keterodate.caption) : null, ew.Validators.datetime(fields.keterodate.clientFormatPattern)], fields.keterodate.isInvalid],
            ["keterodescription", [fields.keterodescription.visible && fields.keterodescription.required ? ew.Validators.required(fields.keterodescription.caption) : null], fields.keterodescription.isInvalid],
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
            "RANKe": <?= $Page->RANKe->toClientList($Page) ?>,
            "ez": <?= $Page->ez->toClientList($Page) ?>,
            "firdbet": <?= $Page->firdbet->toClientList($Page) ?>,
            "chilotname": <?= $Page->chilotname->toClientList($Page) ?>,
            "kirihidet": <?= $Page->kirihidet->toClientList($Page) ?>,
            "yekisaynet": <?= $Page->yekisaynet->toClientList($Page) ?>,
            "keteroreason": <?= $Page->keteroreason->toClientList($Page) ?>,
            "sex": <?= $Page->sex->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="case_hears">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->melequtir->Visible) { // melequtir ?>
    <div id="r_melequtir"<?= $Page->melequtir->rowAttributes() ?>>
        <label id="elh_case_hears_melequtir" for="x_melequtir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->melequtir->caption() ?><?= $Page->melequtir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->melequtir->cellAttributes() ?>>
<span id="el_case_hears_melequtir">
<input type="<?= $Page->melequtir->getInputTextType() ?>" name="x_melequtir" id="x_melequtir" data-table="case_hears" data-field="x_melequtir" value="<?= $Page->melequtir->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->melequtir->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->melequtir->formatPattern()) ?>"<?= $Page->melequtir->editAttributes() ?> aria-describedby="x_melequtir_help">
<?= $Page->melequtir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->melequtir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->RANKe->Visible) { // RANKe ?>
    <div id="r_RANKe"<?= $Page->RANKe->rowAttributes() ?>>
        <label id="elh_case_hears_RANKe" for="x_RANKe" class="<?= $Page->LeftColumnClass ?>"><?= $Page->RANKe->caption() ?><?= $Page->RANKe->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->RANKe->cellAttributes() ?>>
<span id="el_case_hears_RANKe">
    <select
        id="x_RANKe"
        name="x_RANKe"
        class="form-select ew-select<?= $Page->RANKe->isInvalidClass() ?>"
        <?php if (!$Page->RANKe->IsNativeSelect) { ?>
        data-select2-id="fcase_hearsedit_x_RANKe"
        <?php } ?>
        data-table="case_hears"
        data-field="x_RANKe"
        data-value-separator="<?= $Page->RANKe->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->RANKe->getPlaceHolder()) ?>"
        <?= $Page->RANKe->editAttributes() ?>>
        <?= $Page->RANKe->selectOptionListHtml("x_RANKe") ?>
    </select>
    <?= $Page->RANKe->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->RANKe->getErrorMessage() ?></div>
<?= $Page->RANKe->Lookup->getParamTag($Page, "p_x_RANKe") ?>
<?php if (!$Page->RANKe->IsNativeSelect) { ?>
<script>
loadjs.ready("fcase_hearsedit", function() {
    var options = { name: "x_RANKe", selectId: "fcase_hearsedit_x_RANKe" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcase_hearsedit.lists.RANKe?.lookupOptions.length) {
        options.data = { id: "x_RANKe", form: "fcase_hearsedit" };
    } else {
        options.ajax = { id: "x_RANKe", form: "fcase_hearsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.case_hears.fields.RANKe.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_case_hears_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_case_hears_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="case_hears" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name->formatPattern()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ez->Visible) { // ez ?>
    <div id="r_ez"<?= $Page->ez->rowAttributes() ?>>
        <label id="elh_case_hears_ez" for="x_ez" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ez->caption() ?><?= $Page->ez->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ez->cellAttributes() ?>>
<span id="el_case_hears_ez">
    <select
        id="x_ez"
        name="x_ez"
        class="form-select ew-select<?= $Page->ez->isInvalidClass() ?>"
        <?php if (!$Page->ez->IsNativeSelect) { ?>
        data-select2-id="fcase_hearsedit_x_ez"
        <?php } ?>
        data-table="case_hears"
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
loadjs.ready("fcase_hearsedit", function() {
    var options = { name: "x_ez", selectId: "fcase_hearsedit_x_ez" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcase_hearsedit.lists.ez?.lookupOptions.length) {
        options.data = { id: "x_ez", form: "fcase_hearsedit" };
    } else {
        options.ajax = { id: "x_ez", form: "fcase_hearsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.case_hears.fields.ez.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fileNumber->Visible) { // fileNumber ?>
    <div id="r_fileNumber"<?= $Page->fileNumber->rowAttributes() ?>>
        <label id="elh_case_hears_fileNumber" for="x_fileNumber" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fileNumber->caption() ?><?= $Page->fileNumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fileNumber->cellAttributes() ?>>
<span id="el_case_hears_fileNumber">
<input type="<?= $Page->fileNumber->getInputTextType() ?>" name="x_fileNumber" id="x_fileNumber" data-table="case_hears" data-field="x_fileNumber" value="<?= $Page->fileNumber->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->fileNumber->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fileNumber->formatPattern()) ?>"<?= $Page->fileNumber->editAttributes() ?> aria-describedby="x_fileNumber_help">
<?= $Page->fileNumber->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fileNumber->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->firdbet->Visible) { // firdbet ?>
    <div id="r_firdbet"<?= $Page->firdbet->rowAttributes() ?>>
        <label id="elh_case_hears_firdbet" for="x_firdbet" class="<?= $Page->LeftColumnClass ?>"><?= $Page->firdbet->caption() ?><?= $Page->firdbet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->firdbet->cellAttributes() ?>>
<span id="el_case_hears_firdbet">
    <select
        id="x_firdbet"
        name="x_firdbet"
        class="form-select ew-select<?= $Page->firdbet->isInvalidClass() ?>"
        <?php if (!$Page->firdbet->IsNativeSelect) { ?>
        data-select2-id="fcase_hearsedit_x_firdbet"
        <?php } ?>
        data-table="case_hears"
        data-field="x_firdbet"
        data-value-separator="<?= $Page->firdbet->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->firdbet->getPlaceHolder()) ?>"
        <?= $Page->firdbet->editAttributes() ?>>
        <?= $Page->firdbet->selectOptionListHtml("x_firdbet") ?>
    </select>
    <?= $Page->firdbet->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->firdbet->getErrorMessage() ?></div>
<?= $Page->firdbet->Lookup->getParamTag($Page, "p_x_firdbet") ?>
<?php if (!$Page->firdbet->IsNativeSelect) { ?>
<script>
loadjs.ready("fcase_hearsedit", function() {
    var options = { name: "x_firdbet", selectId: "fcase_hearsedit_x_firdbet" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcase_hearsedit.lists.firdbet?.lookupOptions.length) {
        options.data = { id: "x_firdbet", form: "fcase_hearsedit" };
    } else {
        options.ajax = { id: "x_firdbet", form: "fcase_hearsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.case_hears.fields.firdbet.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chilotname->Visible) { // chilotname ?>
    <div id="r_chilotname"<?= $Page->chilotname->rowAttributes() ?>>
        <label id="elh_case_hears_chilotname" for="x_chilotname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chilotname->caption() ?><?= $Page->chilotname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->chilotname->cellAttributes() ?>>
<span id="el_case_hears_chilotname">
    <select
        id="x_chilotname"
        name="x_chilotname"
        class="form-select ew-select<?= $Page->chilotname->isInvalidClass() ?>"
        <?php if (!$Page->chilotname->IsNativeSelect) { ?>
        data-select2-id="fcase_hearsedit_x_chilotname"
        <?php } ?>
        data-table="case_hears"
        data-field="x_chilotname"
        data-value-separator="<?= $Page->chilotname->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->chilotname->getPlaceHolder()) ?>"
        <?= $Page->chilotname->editAttributes() ?>>
        <?= $Page->chilotname->selectOptionListHtml("x_chilotname") ?>
    </select>
    <?= $Page->chilotname->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->chilotname->getErrorMessage() ?></div>
<?= $Page->chilotname->Lookup->getParamTag($Page, "p_x_chilotname") ?>
<?php if (!$Page->chilotname->IsNativeSelect) { ?>
<script>
loadjs.ready("fcase_hearsedit", function() {
    var options = { name: "x_chilotname", selectId: "fcase_hearsedit_x_chilotname" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcase_hearsedit.lists.chilotname?.lookupOptions.length) {
        options.data = { id: "x_chilotname", form: "fcase_hearsedit" };
    } else {
        options.ajax = { id: "x_chilotname", form: "fcase_hearsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.case_hears.fields.chilotname.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kirihidet->Visible) { // kirihidet ?>
    <div id="r_kirihidet"<?= $Page->kirihidet->rowAttributes() ?>>
        <label id="elh_case_hears_kirihidet" for="x_kirihidet" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kirihidet->caption() ?><?= $Page->kirihidet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kirihidet->cellAttributes() ?>>
<span id="el_case_hears_kirihidet">
    <select
        id="x_kirihidet"
        name="x_kirihidet"
        class="form-select ew-select<?= $Page->kirihidet->isInvalidClass() ?>"
        <?php if (!$Page->kirihidet->IsNativeSelect) { ?>
        data-select2-id="fcase_hearsedit_x_kirihidet"
        <?php } ?>
        data-table="case_hears"
        data-field="x_kirihidet"
        data-value-separator="<?= $Page->kirihidet->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->kirihidet->getPlaceHolder()) ?>"
        <?= $Page->kirihidet->editAttributes() ?>>
        <?= $Page->kirihidet->selectOptionListHtml("x_kirihidet") ?>
    </select>
    <?= $Page->kirihidet->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->kirihidet->getErrorMessage() ?></div>
<?= $Page->kirihidet->Lookup->getParamTag($Page, "p_x_kirihidet") ?>
<?php if (!$Page->kirihidet->IsNativeSelect) { ?>
<script>
loadjs.ready("fcase_hearsedit", function() {
    var options = { name: "x_kirihidet", selectId: "fcase_hearsedit_x_kirihidet" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcase_hearsedit.lists.kirihidet?.lookupOptions.length) {
        options.data = { id: "x_kirihidet", form: "fcase_hearsedit" };
    } else {
        options.ajax = { id: "x_kirihidet", form: "fcase_hearsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.case_hears.fields.kirihidet.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->yekisaynet->Visible) { // yekisaynet ?>
    <div id="r_yekisaynet"<?= $Page->yekisaynet->rowAttributes() ?>>
        <label id="elh_case_hears_yekisaynet" for="x_yekisaynet" class="<?= $Page->LeftColumnClass ?>"><?= $Page->yekisaynet->caption() ?><?= $Page->yekisaynet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->yekisaynet->cellAttributes() ?>>
<span id="el_case_hears_yekisaynet">
    <select
        id="x_yekisaynet"
        name="x_yekisaynet"
        class="form-select ew-select<?= $Page->yekisaynet->isInvalidClass() ?>"
        <?php if (!$Page->yekisaynet->IsNativeSelect) { ?>
        data-select2-id="fcase_hearsedit_x_yekisaynet"
        <?php } ?>
        data-table="case_hears"
        data-field="x_yekisaynet"
        data-value-separator="<?= $Page->yekisaynet->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->yekisaynet->getPlaceHolder()) ?>"
        <?= $Page->yekisaynet->editAttributes() ?>>
        <?= $Page->yekisaynet->selectOptionListHtml("x_yekisaynet") ?>
    </select>
    <?= $Page->yekisaynet->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->yekisaynet->getErrorMessage() ?></div>
<?= $Page->yekisaynet->Lookup->getParamTag($Page, "p_x_yekisaynet") ?>
<?php if (!$Page->yekisaynet->IsNativeSelect) { ?>
<script>
loadjs.ready("fcase_hearsedit", function() {
    var options = { name: "x_yekisaynet", selectId: "fcase_hearsedit_x_yekisaynet" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcase_hearsedit.lists.yekisaynet?.lookupOptions.length) {
        options.data = { id: "x_yekisaynet", form: "fcase_hearsedit" };
    } else {
        options.ajax = { id: "x_yekisaynet", form: "fcase_hearsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.case_hears.fields.yekisaynet.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keteroreason->Visible) { // keteroreason ?>
    <div id="r_keteroreason"<?= $Page->keteroreason->rowAttributes() ?>>
        <label id="elh_case_hears_keteroreason" for="x_keteroreason" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keteroreason->caption() ?><?= $Page->keteroreason->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->keteroreason->cellAttributes() ?>>
<span id="el_case_hears_keteroreason">
    <select
        id="x_keteroreason"
        name="x_keteroreason"
        class="form-select ew-select<?= $Page->keteroreason->isInvalidClass() ?>"
        <?php if (!$Page->keteroreason->IsNativeSelect) { ?>
        data-select2-id="fcase_hearsedit_x_keteroreason"
        <?php } ?>
        data-table="case_hears"
        data-field="x_keteroreason"
        data-value-separator="<?= $Page->keteroreason->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->keteroreason->getPlaceHolder()) ?>"
        <?= $Page->keteroreason->editAttributes() ?>>
        <?= $Page->keteroreason->selectOptionListHtml("x_keteroreason") ?>
    </select>
    <?= $Page->keteroreason->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->keteroreason->getErrorMessage() ?></div>
<?= $Page->keteroreason->Lookup->getParamTag($Page, "p_x_keteroreason") ?>
<?php if (!$Page->keteroreason->IsNativeSelect) { ?>
<script>
loadjs.ready("fcase_hearsedit", function() {
    var options = { name: "x_keteroreason", selectId: "fcase_hearsedit_x_keteroreason" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcase_hearsedit.lists.keteroreason?.lookupOptions.length) {
        options.data = { id: "x_keteroreason", form: "fcase_hearsedit" };
    } else {
        options.ajax = { id: "x_keteroreason", form: "fcase_hearsedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.case_hears.fields.keteroreason.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sex->Visible) { // sex ?>
    <div id="r_sex"<?= $Page->sex->rowAttributes() ?>>
        <label id="elh_case_hears_sex" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sex->caption() ?><?= $Page->sex->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sex->cellAttributes() ?>>
<span id="el_case_hears_sex">
<template id="tp_x_sex">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="case_hears" data-field="x_sex" name="x_sex" id="x_sex"<?= $Page->sex->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_sex" class="ew-item-list"></div>
<selection-list hidden
    id="x_sex"
    name="x_sex"
    value="<?= HtmlEncode($Page->sex->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_sex"
    data-target="dsl_x_sex"
    data-repeatcolumn="5"
    class="form-control<?= $Page->sex->isInvalidClass() ?>"
    data-table="case_hears"
    data-field="x_sex"
    data-value-separator="<?= $Page->sex->displayValueSeparatorAttribute() ?>"
    <?= $Page->sex->editAttributes() ?>></selection-list>
<?= $Page->sex->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sex->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tekesashbizat->Visible) { // tekesashbizat ?>
    <div id="r_tekesashbizat"<?= $Page->tekesashbizat->rowAttributes() ?>>
        <label id="elh_case_hears_tekesashbizat" for="x_tekesashbizat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tekesashbizat->caption() ?><?= $Page->tekesashbizat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tekesashbizat->cellAttributes() ?>>
<span id="el_case_hears_tekesashbizat">
<input type="<?= $Page->tekesashbizat->getInputTextType() ?>" name="x_tekesashbizat" id="x_tekesashbizat" data-table="case_hears" data-field="x_tekesashbizat" value="<?= $Page->tekesashbizat->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tekesashbizat->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tekesashbizat->formatPattern()) ?>"<?= $Page->tekesashbizat->editAttributes() ?> aria-describedby="x_tekesashbizat_help">
<?= $Page->tekesashbizat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tekesashbizat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterodate->Visible) { // keterodate ?>
    <div id="r_keterodate"<?= $Page->keterodate->rowAttributes() ?>>
        <label id="elh_case_hears_keterodate" for="x_keterodate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterodate->caption() ?><?= $Page->keterodate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->keterodate->cellAttributes() ?>>
<span id="el_case_hears_keterodate">
<input type="<?= $Page->keterodate->getInputTextType() ?>" name="x_keterodate" id="x_keterodate" data-table="case_hears" data-field="x_keterodate" value="<?= $Page->keterodate->EditValue ?>" placeholder="<?= HtmlEncode($Page->keterodate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->keterodate->formatPattern()) ?>"<?= $Page->keterodate->editAttributes() ?> aria-describedby="x_keterodate_help">
<?= $Page->keterodate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterodate->getErrorMessage() ?></div>
<?php if (!$Page->keterodate->ReadOnly && !$Page->keterodate->Disabled && !isset($Page->keterodate->EditAttrs["readonly"]) && !isset($Page->keterodate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcase_hearsedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcase_hearsedit", "x_keterodate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterodescription->Visible) { // keterodescription ?>
    <div id="r_keterodescription"<?= $Page->keterodescription->rowAttributes() ?>>
        <label id="elh_case_hears_keterodescription" for="x_keterodescription" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterodescription->caption() ?><?= $Page->keterodescription->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->keterodescription->cellAttributes() ?>>
<span id="el_case_hears_keterodescription">
<input type="<?= $Page->keterodescription->getInputTextType() ?>" name="x_keterodescription" id="x_keterodescription" data-table="case_hears" data-field="x_keterodescription" value="<?= $Page->keterodescription->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->keterodescription->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->keterodescription->formatPattern()) ?>"<?= $Page->keterodescription->editAttributes() ?> aria-describedby="x_keterodescription_help">
<?= $Page->keterodescription->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterodescription->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <label id="elh_case_hears_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->created_at->cellAttributes() ?>>
<span id="el_case_hears_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="case_hears" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcase_hearsedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcase_hearsedit", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="case_hears" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcase_hearsedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcase_hearsedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("case_hears");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
