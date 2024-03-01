<?php

namespace PHPMaker2024\project2;

// Page object
$UsersAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fusersadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fusersadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
            ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
            ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
            ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
            ["current_team_id", [fields.current_team_id.visible && fields.current_team_id.required ? ew.Validators.required(fields.current_team_id.caption) : null], fields.current_team_id.isInvalid],
            ["profile_photo_path", [fields.profile_photo_path.visible && fields.profile_photo_path.required ? ew.Validators.required(fields.profile_photo_path.caption) : null], fields.profile_photo_path.isInvalid],
            ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(fields.created_at.clientFormatPattern)], fields.created_at.isInvalid],
            ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null], fields.updated_at.isInvalid]
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
            "current_team_id": <?= $Page->current_team_id->toClientList($Page) ?>,
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
<form name="fusersadd" id="fusersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_users_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_users_id">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="users" data-field="x_id" value="<?= $Page->id->EditValue ?>" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id->formatPattern()) ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_users_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_users_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="users" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name->formatPattern()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_users__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_users__email">
    <select
        id="x__email"
        name="x__email"
        class="form-select ew-select<?= $Page->_email->isInvalidClass() ?>"
        <?php if (!$Page->_email->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x__email"
        <?php } ?>
        data-table="users"
        data-field="x__email"
        data-value-separator="<?= $Page->_email->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"
        <?= $Page->_email->editAttributes() ?>>
        <?= $Page->_email->selectOptionListHtml("x__email") ?>
    </select>
    <?= $Page->_email->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
<?php if (!$Page->_email->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x__email", selectId: "fusersadd_x__email" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists._email?.lookupOptions.length) {
        options.data = { id: "x__email", form: "fusersadd" };
    } else {
        options.ajax = { id: "x__email", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields._email.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("add")) { // Non system admin ?>
<span id="el_users__email">
    <select
        id="x__email"
        name="x__email"
        class="form-select ew-select<?= $Page->_email->isInvalidClass() ?>"
        <?php if (!$Page->_email->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x__email"
        <?php } ?>
        data-table="users"
        data-field="x__email"
        data-value-separator="<?= $Page->_email->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"
        <?= $Page->_email->editAttributes() ?>>
        <?= $Page->_email->selectOptionListHtml("x__email") ?>
    </select>
    <?= $Page->_email->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
<?php if (!$Page->_email->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x__email", selectId: "fusersadd_x__email" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists._email?.lookupOptions.length) {
        options.data = { id: "x__email", form: "fusersadd" };
    } else {
        options.ajax = { id: "x__email", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields._email.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="users" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <label id="elh_users__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<span id="el_users__password">
<input type="<?= $Page->_password->getInputTextType() ?>" name="x__password" id="x__password" data-table="users" data-field="x__password" value="<?= $Page->_password->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_password->formatPattern()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_users_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_users_description">
<textarea data-table="users" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->current_team_id->Visible) { // current_team_id ?>
    <div id="r_current_team_id"<?= $Page->current_team_id->rowAttributes() ?>>
        <label id="elh_users_current_team_id" for="x_current_team_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->current_team_id->caption() ?><?= $Page->current_team_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->current_team_id->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_users_current_team_id">
<span class="form-control-plaintext"><?= $Page->current_team_id->getDisplayValue($Page->current_team_id->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_users_current_team_id">
    <select
        id="x_current_team_id"
        name="x_current_team_id"
        class="form-select ew-select<?= $Page->current_team_id->isInvalidClass() ?>"
        <?php if (!$Page->current_team_id->IsNativeSelect) { ?>
        data-select2-id="fusersadd_x_current_team_id"
        <?php } ?>
        data-table="users"
        data-field="x_current_team_id"
        data-value-separator="<?= $Page->current_team_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->current_team_id->getPlaceHolder()) ?>"
        <?= $Page->current_team_id->editAttributes() ?>>
        <?= $Page->current_team_id->selectOptionListHtml("x_current_team_id") ?>
    </select>
    <?= $Page->current_team_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->current_team_id->getErrorMessage() ?></div>
<?= $Page->current_team_id->Lookup->getParamTag($Page, "p_x_current_team_id") ?>
<?php if (!$Page->current_team_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fusersadd", function() {
    var options = { name: "x_current_team_id", selectId: "fusersadd_x_current_team_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fusersadd.lists.current_team_id?.lookupOptions.length) {
        options.data = { id: "x_current_team_id", form: "fusersadd" };
    } else {
        options.ajax = { id: "x_current_team_id", form: "fusersadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.current_team_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->profile_photo_path->Visible) { // profile_photo_path ?>
    <div id="r_profile_photo_path"<?= $Page->profile_photo_path->rowAttributes() ?>>
        <label id="elh_users_profile_photo_path" for="x_profile_photo_path" class="<?= $Page->LeftColumnClass ?>"><?= $Page->profile_photo_path->caption() ?><?= $Page->profile_photo_path->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->profile_photo_path->cellAttributes() ?>>
<span id="el_users_profile_photo_path">
<textarea data-table="users" data-field="x_profile_photo_path" name="x_profile_photo_path" id="x_profile_photo_path" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->profile_photo_path->getPlaceHolder()) ?>"<?= $Page->profile_photo_path->editAttributes() ?> aria-describedby="x_profile_photo_path_help"><?= $Page->profile_photo_path->EditValue ?></textarea>
<?= $Page->profile_photo_path->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->profile_photo_path->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <label id="elh_users_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->created_at->cellAttributes() ?>>
<span id="el_users_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="users" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fusersadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fusersadd", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fusersadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fusersadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
