const init = () => {
    // prevent run if not on correct route
    const validPath = () => {
        const routes = ['/positiondescription/validateDEP']
        for (const route of routes) {
            if (~window.location.pathname.indexOf(route)) return true
        }
        return false
    }
    if (!validPath()) return

    // remove line
    function removeLine(element, msg = null, closest = null) {
        var _msg = msg ? msg : 'Deseja realmente excluir?';

        if (!confirm(_msg)) return;

        if (closest) return element.closest(closest).remove();

        element.parentElement.parentElement.remove();
    }

    // add td
    function addTd({ type = 'line', fn = null, dataset, text, row }) {
        const td = document.createElement('td')
        const i = document.createElement('i')

        switch (type) {
            case 'btn':
                i.classList = 'far fa-trash-alt'
                i.addEventListener('click', fn)
                td.appendChild(i)
                break;
                
            default:
                td.setAttribute(`data-${dataset.key}`, dataset.value)
                td.innerText = text
                break;
        }

        row.appendChild(td)
    }

    // autocomplete
    function autocomplete(inp, arr, hiddenclass, sizesearch = 5) {
        // prevent error if input is null
        if (!inp) return
        
        // add active option
        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;

            /*start by removing the "active" class on all items:*/
            removeActive(x);

            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);

            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        // remove active option
        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (let i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        // close all lists
        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (let i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }

        // disable competence level
        if ([...inp.classList].includes('competencelevel')) toggleEnabledCompetenceFields(true);

        // reset hiddenClass value
        if (inp.parentElement.querySelector(hiddenclass)) {
            inp.parentElement.querySelector(hiddenclass).value = '-1';
        }

        /** the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values: */
        var currentFocus;

        /** execute a function when someone writes in the text field: */
        inp.addEventListener("input", function (e) {
            // return if input query is too short
            if (e.target.value.length < sizesearch) return;

            var a, b, i, val = this.value;

            // query data-type
            const type = e.target.dataset.type

            /** close any already open lists of autocompleted values */
            closeAllLists();

            // return if value is null
            if (!val) return false;

            currentFocus = -1;

            /** create a DIV element that will contain the items (values): */
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");

            /** append the DIV element as a child of the autocomplete container: */
            this.parentNode.appendChild(a);

            // reset hiddenClass value
            if (inp.parentElement.querySelector(hiddenclass)) {
                inp.parentElement.querySelector(hiddenclass).value = '-1';
            }

            /** for each item in the array... */
            for (let i = 0; i < arr.length; i++) {
                /** check if the item starts with the same letters as the text field value: */
                if (arr[i].description.toUpperCase().includes(val.toUpperCase())) {
                    /** create a DIV element for each matching element: */
                    b = document.createElement("DIV");

                    /** make the matching letters TRUE => THE CHOSEN ONES: */
                    const directorates = fields[6].arr
                    let directorateName = ''
                    if (type === 'position') {
                        for (const directorate of directorates) {
                            if (directorate.id === arr[i].directorate_id) {
                                directorateName = ` (${directorate.description})`
                                break
                            }
                        }
                    }
                    b.innerHTML = `${arr[i].description}${directorateName}`

                    /** insert a input field that will hold the current array item's value: */
                    b.innerHTML += "<input type='hidden' value='" + arr[i].id + "'>";

                    /** execute a function when someone clicks on the item value (DIV element): */
                    b.addEventListener("click", function (e) {
                        /** insert the value for the autocomplete text field: */
                        inp.value = e.target.innerText;
                        inp.parentElement.querySelector(hiddenclass).value = e.target.children[0].value;

                        // close opened lists
                        closeAllLists();
                    });

                    a.appendChild(b);
                }
            }
        });

        /** execute a function presses a key on the keyboard: */
        inp.addEventListener("keydown", function (e) {
            var x = document.getElementById(this.id + "autocomplete-list");

            if (x) x = x.getElementsByTagName("div");

            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;

                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;

                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();

                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        /** execute a function when someone clicks in the document: */
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    // grade : filter options
    function filterGradeCourse(event) {
        var element = event.target;

        // reset 
        document.querySelector(".gradecourse-id").value = -1;
        document.querySelector(".gradecourse").value = "";

        // filtered array
        var arr = [];

        // keys
        var mainKey = element.dataset.key; // 'grade_id' or 'area_id'    
        var auxKey = mainKey === 'area_id' ? 'grade_id' : 'area_id';

        // ids
        var mainID = element.options[element.selectedIndex].value;
        var auxID = document.querySelector('[data-key="' + auxKey + '"]').value;

        if (document.querySelector('.area').value == "" && document.querySelector('.grade').value == "") {
            arr = fields[1].arr;
        } else {
            for (let i = 0; i < fields[1].arr.length; i++) {
                // qdo os dois campos não são nulos
                if (mainID !== "" && auxID !== "") {
                    if (fields[1].arr[i][mainKey] == mainID && fields[1].arr[i][auxKey] == auxID) {
                        arr.push(fields[1].arr[i]);
                    }

                    // qdo mainID É nulo e auxID NÃO É
                } else if (mainID === "" && auxID !== "") {
                    if (fields[1].arr[i][auxKey] == auxID) {
                        arr.push(fields[1].arr[i]);
                    }

                    // qdo mainID NÃO É nulo e auxID É
                } else if (mainID !== "" && auxID === "") {
                    if (fields[1].arr[i][mainKey] == mainID) {
                        arr.push(fields[1].arr[i]);
                    }
                } else {
                    console.error("validação não prevista!");
                }
            }
        }

        // fill course input
        autocomplete(document.querySelector(fields[1].target), arr, fields[1].hiddenclass);
    }

    // grade : add line
    function addGradeCourse(event) {
        event.preventDefault();

        var wrapper = document.querySelector('.wrapperGrade');
        var tablerow = document.querySelector('.tablegrades tbody');

        var inputs = wrapper.children[1].querySelectorAll('input');
        var gradestatus = wrapper.children[2].children[0].querySelector('select');
        var graderequirement = wrapper.children[2].children[1].querySelector('select');
        var grade = wrapper.children[0].querySelector('.grade');
        var gradearea = wrapper.children[0].querySelector('.area');

        var gradeId = grade.options[grade.selectedIndex].value;
        var gradeDescription = grade.options[grade.selectedIndex].text;
        var areaId = gradearea.options[gradearea.selectedIndex].value;
        var areaDescription = gradearea.options[gradearea.selectedIndex].text;

        if (inputs[0].value == "-1") {
            if ((grade.options[grade.selectedIndex].value == "" || gradearea.options[gradearea.selectedIndex].value == "") && inputs[1].value != "") {
                alert("Para novo Curso, é necessário preencher área e grau!");
                return;
            }

            if (inputs[1].value == "") {
                alert("Obrigatório preencher o curso!");
                return;
            }
        } else {

            for (let i = 0; i < fields[1].arr.length; i++) {

                if (inputs[0].value == fields[1].arr[i].id) {

                    gradeId = fields[1].arr[i].grade_id;
                    gradeDescription = document.querySelector('.grade option[value="' + gradeId + '"]').text;
                    areaId = fields[1].arr[i].area_id;
                    areaDescription = document.querySelector('.area option[value="' + areaId + '"]').text;

                    break;
                }
            }
        }

        const row = document.createElement('tr');

        addTd({ dataset: { key: 'id', value: inputs[0].value }, text: inputs[1].value, row: row })
        addTd({ dataset: { key: 'grade', value: gradeId }, text: gradeDescription, row: row })
        addTd({ dataset: { key: 'gradearea', value: areaId }, text: areaDescription, row: row })
        addTd({ dataset: { key: 'gradestatus', value: gradestatus.options[gradestatus.selectedIndex].value }, text: gradestatus.options[gradestatus.selectedIndex].text, row: row })
        addTd({ dataset: { key: 'graderequirement', value: graderequirement.options[graderequirement.selectedIndex].value }, text: graderequirement.options[graderequirement.selectedIndex].text, row: row })
        addTd({ type: 'btn', fn: removeGradeCourse, row: row })

        tablerow.appendChild(row);

        document.querySelector(".grade").value = "";
        document.querySelector(".area").value = "";
        document.querySelector(".gradecourse-id").value = -1;
        document.querySelector(".gradecourse").value = "";

    }

    // grade : remove line
    function removeGradeCourse(e) {
        removeLine(e.target)
    }

    // language : add line
    function addLanguage(event) {
        event.preventDefault();

        var wrapper = document.querySelector('.wrapperlanguage');
        var tablerow = document.querySelector('.tablelanguages tbody');

        var selects = wrapper.querySelectorAll('select');

        const row = document.createElement('tr')

        addTd({ dataset: { key: 'id', value: selects[0].options[selects[0].selectedIndex].value }, text: selects[0].options[selects[0].selectedIndex].text, row: row })
        addTd({ dataset: { key: 'languageskill', value: selects[1].options[selects[1].selectedIndex].value }, text: selects[1].options[selects[1].selectedIndex].text, row: row })
        addTd({ dataset: { key: 'languagelevel', value: selects[2].options[selects[2].selectedIndex].value }, text: selects[2].options[selects[2].selectedIndex].text, row: row })
        addTd({ dataset: { key: 'languagerequirement', value: selects[3].options[selects[3].selectedIndex].value }, text: selects[3].options[selects[3].selectedIndex].text, row: row })
        addTd({ type: 'btn', fn: removeLanguage, row: row })

        tablerow.appendChild(row);
    }

    // language : remove line
    function removeLanguage(e) {
        removeLine(e.target)
    }

    // competence : filter options
    function filterByCompetenceType(event) {
        // ETAPA 0 - Clean fields
        document.querySelector('.competence').value = "";
        document.querySelector('.competence-id').value = "-1";

        // ETAPA 1 - Toggle Disabled fields to filter
        var element = event.target;
        var isDisabled = parseInt(element.options[element.selectedIndex].value) == 0;

        toggleEnabledCompetenceFields(isDisabled);

        // ETAPA 2 Filter autocomplete Comptence field
        var filterId = element.options[element.selectedIndex].value;
        var datakey = element.dataset.key;
        var arr = [];

        for (let i = 0; i < fields[2].arr.length; i++) {
            if (fields[2].arr[i][datakey] == filterId) {
                arr.push(fields[2].arr[i]);
            }
        }

        autocomplete(document.querySelector(fields[2].target), arr, fields[2].hiddenclass, fields[2].sizesearch);

        // ETAPA 3 - Filter Competence Level
        var competenceLevel = document.querySelector(".competencelevel");

        // limpa as opções
        while (competenceLevel.hasChildNodes()) {
            competenceLevel.removeChild(competenceLevel.firstChild);
        }

        // percorre as opções de nível da habilidade
        for (let i = 0; i < fields[3].arr.length; i++) {
            // traz os ids selecionados no tipo de habilidade
            if (fields[3].arr[i][datakey] == filterId) {
                var option = document.createElement("option");

                option.text = fields[3].arr[i].description;
                option.value = fields[3].arr[i].id;
                competenceLevel.add(option);
            }
        }
    }

    // competence : toggle
    function toggleEnabledCompetenceFields(isDisabled) {
        document.querySelector('.competence').disabled = isDisabled;
        document.querySelector('.competencelevel').disabled = isDisabled;
    }

    // competence : add line
    function addCompetence(event) {
        event.preventDefault();

        var wrapper = document.querySelector('.wrappercompetence');
        var tablerow = document.querySelector('.tablecompetences tbody');

        var competenceTypeField = wrapper.querySelector('.competencetype');
        var competenceIdField = wrapper.querySelector('.competence-id');
        var competenceField = wrapper.querySelector('.competence');
        var competenceRequirementField = wrapper.querySelector('.competencerequirement');
        var competenceLevelField = wrapper.querySelector('.competencelevel');

        const row = document.createElement('tr')

        addTd({ dataset: { key: 'competencetype', value: competenceTypeField.options[competenceTypeField.selectedIndex].value }, text: competenceTypeField.options[competenceTypeField.selectedIndex].text, row: row })
        addTd({ dataset: { key: 'id', value: competenceIdField.value }, text: competenceField.value, row: row })
        addTd({ dataset: { key: 'competencelevel', value: competenceLevelField.options[competenceLevelField.selectedIndex].value }, text: competenceLevelField.options[competenceLevelField.selectedIndex].text, row: row })
        addTd({ dataset: { key: 'competencerequirement', value: competenceRequirementField.options[competenceRequirementField.selectedIndex].value }, text: competenceRequirementField.options[competenceRequirementField.selectedIndex].text, row: row })
        addTd({ type: 'btn', fn: removeCompetence, row: row })

        tablerow.appendChild(row);
    }

    // competence : remove line
    function removeCompetence(e) {
        removeLine(e.target)
    }

    // target : add line
    function addTarget(event) {
        event.preventDefault();

        var wrapper = document.querySelector('.wrappertarget');
        var newtarget = document.querySelector('.containertarget.d-none').cloneNode(true);

        newtarget.classList.remove('d-none');

        wrapper.insertAdjacentElement('afterbegin', newtarget);

        newtarget.querySelector('i').addEventListener('click', removeTarget);
        newtarget.querySelector('.addactivity').addEventListener('click', addActivity);

        autocomplete(
            newtarget.querySelector(fields[4].target),
            fields[4].arr,
            fields[4].hiddenclass
        );
    }

    // target : remove line
    function removeTarget(e) {
        var msg = 'Deseja realmente excluir este Objetivo e TODAS as Atividades?';
        removeLine(e.target, msg, '.containertarget');
    }

    // activity : add line
    function addActivity(event) {

        event.preventDefault();

        var wrapper = event.target.parentElement;
        var newactivity = document.querySelector('.containeractivity.d-none').cloneNode(true);

        newactivity.classList.remove('d-none');
        newactivity.classList.add('d-flex');

        newactivity.querySelector('i').addEventListener('click', removeActivity)

        wrapper.insertAdjacentElement('afterbegin', newactivity);

        autocomplete(newactivity.querySelector(fields[5].target), fields[5].arr, fields[5].hiddenclass);
    }

    // activity : remove line
    function removeActivity(e) {
        var msg = 'Deseja realmente excluir esta Atividade?';
        removeLine(e.target, msg, '.containeractivity');
    }

    // remove quotes from text due to parse error
    function removeQuoteFromText(text) {
        return text.replace(/(\")/g, '');
    }

    // form : save
    function savePositionDescription(event) {
        event.preventDefault();

        var data = {};
        var form = document.querySelector('#formdep');

        var positionData = {
            position_id: form.querySelector('.position-id').value,
            position: removeQuoteFromText(form.querySelector('.position').value),
            interviewed: form.querySelector('input[name="interviewed"]:checked').value,
            mission: removeQuoteFromText(form.querySelector('.mission').value),
            experience_time: form.querySelector('.experiencetime').value,
            leadership_time: form.querySelector('.leadershiptime').value,
            allowhomeoffice: form.querySelector('input[name="allowhomeoffice"]:checked').value,
            interviewer_comments: removeQuoteFromText(form.querySelector('.interviewercomments').value)
        };

        if (positionData.position_id == -1) return alert("Selecione uma posição da Listagem!");

        data = Object.assign(data, positionData);

        var tableGrade = Array.from(document.querySelectorAll('.tablegrades tbody tr'));
        var gradeCourseData = [];

        for (let i = 0; i < tableGrade.length; i++) {
            gradeCourseData.push({
                grade_course_id: tableGrade[i].children[0].dataset.id,
                grade_course: removeQuoteFromText(tableGrade[i].children[0].innerText),
                status: tableGrade[i].children[1].dataset.gradestatus,
                requirement: tableGrade[i].children[2].dataset.graderequirement,
                grade: tableGrade[i].children[3].dataset.grade,
                area: tableGrade[i].children[4].dataset.gradearea
            });
        }

        data = Object.assign(data, {
            dep_grade: gradeCourseData
        });

        var tableLanguage = Array.from(document.querySelectorAll('.tablelanguages tbody tr'));
        var languageData = [];

        for (let i = 0; i < tableLanguage.length; i++) {
            languageData.push({
                language_id: tableLanguage[i].children[0].dataset.id,
                skill: tableLanguage[i].children[1].dataset.languageskill,
                level: tableLanguage[i].children[2].dataset.languagelevel,
                requirement: tableLanguage[i].children[3].dataset.languagerequirement
            });
        }

        data = Object.assign(data, {
            dep_language: languageData
        });

        var tableCompetence = Array.from(document.querySelectorAll('.tablecompetences tbody tr'));
        var competenceData = [];

        for (let i = 0; i < tableCompetence.length; i++) {
            competenceData.push({
                competence_type_id: tableCompetence[i].children[0].dataset.competencetype,
                competence_id: tableCompetence[i].children[1].dataset.id,
                competence: removeQuoteFromText(tableCompetence[i].children[1].innerText),
                level: tableCompetence[i].children[2].dataset.competencelevel,
                requirement: tableCompetence[i].children[3].dataset.competencerequirement
            });
        }

        data = Object.assign(data, {
            dep_competence: competenceData
        });


        var tableTarget = Array.from(document.querySelectorAll('.wrappertarget .containertarget:not(.d-none)'));
        var targetData = [];

        for (let i = 0; i < tableTarget.length; i++) {
            var activityData = [];
            var tableActivity = Array.from(tableTarget[i].querySelectorAll('.containeractivity'));

            if (tableActivity.length < 1) return alert("Não é permitido Objetivo sem nenhuma atividade!");

            for (let j = 0; j < tableActivity.length; j++) {
                const classification = tableActivity[j].querySelector('select').value

                if (classification.length < 1) return alert("As atividades não podem ficar sem uma classificação");

                activityData.push({
                    activity_id: tableActivity[j].querySelector('.activity-id').value,
                    activity: removeQuoteFromText(tableActivity[j].querySelector('.activity').value),
                    classification: classification,
                    target_order: tableTarget[i].querySelector('.targetorder').value,
                    activity_order: tableActivity[j].querySelector('.activityorder').value,
                });
            }

            targetData.push({
                target_id: tableTarget[i].querySelector('.target-id').value,
                target: removeQuoteFromText(tableTarget[i].querySelector('.target').value),
                activities: activityData
            });
        }

        data = Object.assign(data, {
            dep_maintarget: targetData
        });

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        data = Object.assign(data, {
            _token: CSRF_TOKEN
        });

        let depstorage = '<div class="alert alert-warning"> ATENÇÃO - Caso ocorra algum erro, copie os dados abaixo e envie para o desenvolvedor!';
        depstorage += '<p>Posição: ' + data.position + '</p>';
        depstorage += '<p>Entrevistado: ' + data.interviewed + '</p>';
        depstorage += '<p>Missão: ' + data.mission + '</p>';
        depstorage += '<p>Tempo de Experiência: ' + data.experience_time + ' anos</p>';
        depstorage += '<p>Tempo de Liderança: ' + data.leadership_time + ' anos</p>';
        depstorage += '<p>Mobilidade Opção: ' + data.allowhomeoffice + '</p>';
        depstorage += '<p>Comentários: ' + data.interviewer_comments + '</p>';

        // Store
        localStorage.setItem("depformstorage", depstorage);
        localStorage.setItem("depformstoragedata", JSON.stringify(data));
        // Retrieve
        document.querySelector(".depformstorage").innerHTML = localStorage.getItem("depformstorage");

        $.ajax({
            method: 'POST',
            url: "/positiondescription/create",
            dataType: 'json',
            data: data,
            beforeSend: function () {
                var canvas = document.querySelector('.canvas');
                canvas.classList.add('active');
            },
            success: function (response) {
                console.log(response);

                var canvas = document.querySelector('.canvas');
                canvas.classList.remove('active');

                if (response.status == "error") {
                    alert(response.message);
                } else {
                    alert("Registro Salvo! Clique em OK!")
                    canvas.classList.add('active');
                    window.location.pathname = 'positiondescription'
                }

            },
            error: function (err) {
                var canvas = document.querySelector('.canvas');
                canvas.classList.remove('active');
                console.log(err);
            }
        });
    }

    // form data : validation dep
    function formFill() {
        var dep = {
            positionDescriptions: parseData(window.positionDescriptions),
            depGrades: parseData(window.depGrades),
            depLanguages: parseData(window.depLanguages),
            depCompetences: parseData(window.depCompetences),
            depMainTargets: parseData(window.depMainTargets)
        };

        formFillPositionDescriptions(dep.positionDescriptions);
        formFillGrades(dep.depGrades);
        formFillLanguages(dep.depLanguages);
        formFillCompetences(dep.depCompetences);
        formFillMainTargets(dep.depMainTargets);
    }

    // form data : validation dep - general
    function formFillPositionDescriptions(depPositionDescription) {
        document.querySelector(".position-id").value = depPositionDescription.position_id;

        for (let i = 0; i < fields[0].arr.length; i++) {

            if (depPositionDescription.position_id == fields[0].arr[i].id) {

                document.querySelector(".position").value = fields[0].arr[i].description;
                break;
            }
        }

        document.querySelector(".allowhomeoffice[value='" + depPositionDescription.allowhomeoffice + "']").checked = true;
        document.querySelector(".mission").value = depPositionDescription.mission;
        document.querySelector(".leadershiptime").value = depPositionDescription.leadership_time;
        document.querySelector(".experiencetime").value = depPositionDescription.experience_time;
        document.querySelector(".interviewercomments").value = depPositionDescription.interviewer_comments;
    }

    // form data : validation dep - grade
    function formFillGrades(depGrades) {
        var tablerow = document.querySelector('.tablegrades tbody');

        for (let i = 0; i < depGrades.length; i++) {

            var courseDescription;
            var courseGradeId;
            var courseAreaId;

            for (let j = 0; j < fields[1].arr.length; j++) {

                if (depGrades[i].grade_id == fields[1].arr[j].id) {

                    courseDescription = fields[1].arr[j].description;
                    courseGradeId = fields[1].arr[j].grade_id;
                    courseAreaId = fields[1].arr[j].area_id;
                    break;
                }
            }

            const row = document.createElement('tr');

            addTd({ dataset: { key: 'id', value: depGrades[i].grade_id }, text: courseDescription, row: row })
            addTd({ dataset: { key: 'grade', value: courseGradeId }, text: document.querySelector('.grade option[value="' + courseGradeId + '"]').text, row: row })
            addTd({ dataset: { key: 'gradearea', value: courseAreaId }, text: document.querySelector('.area option[value="' + courseAreaId + '"]').text, row: row })
            addTd({ dataset: { key: 'gradestatus', value: depGrades[i].status }, text: document.querySelector('#gradestatus option[value="' + depGrades[i].status + '"]').text, row: row })
            addTd({ dataset: { key: 'graderequirement', value: depGrades[i].requirement }, text: document.querySelector('#graderequirement option[value="' + depGrades[i].requirement + '"]').text, row: row })
            addTd({ type: 'btn', fn: removeGradeCourse, row: row })

            tablerow.appendChild(row);
        }
    }

    // form data : validation dep - languages
    function formFillLanguages(depLanguages) {
        var tablerow = document.querySelector('.tablelanguages tbody');

        for (let i = 0; i < depLanguages.length; i++) {
            const row = document.createElement('tr')

            addTd({ dataset: { key: 'id', value: depLanguages[i].language_id }, text: document.querySelector('#language option[value="' + depLanguages[i].language_id + '"]').text, row: row })
            addTd({ dataset: { key: 'languageskill', value: depLanguages[i].skill }, text: document.querySelector('#languageskill option[value="' + depLanguages[i].skill + '"]').text, row: row })
            addTd({ dataset: { key: 'languagelevel', value: depLanguages[i].level }, text: document.querySelector('#languagestatus option[value="' + depLanguages[i].level + '"]').text, row: row })
            addTd({ dataset: { key: 'languagerequirement', value: depLanguages[i].requirement }, text: document.querySelector('#languagerequirement option[value="' + depLanguages[i].requirement + '"]').text, row: row })
            addTd({ type: 'btn', fn: removeLanguage, row: row })

            tablerow.appendChild(row);
        }
    }

    // form data : validation dep - competences
    function formFillCompetences(depCompetences) {
        var tablerow = document.querySelector('.tablecompetences tbody');

        for (let i = 0; i < depCompetences.length; i++) {

            var competenceDescription;
            var competenceTypeId;

            for (let j = 0; j < fields[2].arr.length; j++) {

                if (depCompetences[i].competence_id == fields[2].arr[j].id) {

                    competenceDescription = fields[2].arr[j].description;
                    competenceTypeId = fields[2].arr[j].competence_type_id;
                    break;
                }
            }

            const row = document.createElement('tr')

            addTd({ dataset: { key: 'competencetype', value: competenceTypeId }, text: document.querySelector('.competencetype option[value="' + competenceTypeId + '"]').text, row: row })
            addTd({ dataset: { key: 'id', value: depCompetences[i].competence_id }, text: competenceDescription, row: row })
            addTd({ dataset: { key: 'competencelevel', value: depCompetences[i].level }, text: document.querySelector('.competencelevel option[value="' + depCompetences[i].level + '"]').text, row: row })
            addTd({ dataset: { key: 'competencerequirement', value: depCompetences[i].requirement }, text: document.querySelector('.competencerequirement option[value="' + depCompetences[i].requirement + '"]').text, row: row })
            addTd({ type: 'btn', fn: removeCompetence, row: row })

            tablerow.appendChild(row);
        }
    }

    function formFillMainTargets(data) {
        let depMainTargets = data.reduce((depTargetReduced, row) => {
            // set depTargetReduced as an array for the first interaction
            if (!Array.isArray(depTargetReduced)) {
                depTargetReduced = []
            }

            // set current main_target as an array
            if (!depTargetReduced[row.maintarget_id]) {
                depTargetReduced[row.maintarget_id] = []
            }

            // push activity into it
            depTargetReduced[row.maintarget_id].push(row.mainactivity_id)

            // reduce
            return depTargetReduced
        }, [])


        for (let i = 0; i < Object.keys(depMainTargets).length; i++) {
            var targetId;
            var targetDescription;
            var activityIds;

            // Get target info from fields
            for (let j = 0; j < fields[4].arr.length; j++) {

                if (Object.keys(depMainTargets)[i] == fields[4].arr[j].id) {

                    activityIds = Object.values(depMainTargets)[i];
                    targetId = fields[4].arr[j].id;
                    targetDescription = fields[4].arr[j].description;
                    break;
                }
            }

            var wrappertarget = document.querySelector('.wrappertarget');
            var newtarget = document.querySelector('.containertarget.d-none').cloneNode(true);
            newtarget.querySelector('i').addEventListener('click', removeTarget);

            autocomplete(
                newtarget.querySelector(fields[4].target),
                fields[4].arr,
                fields[4].hiddenclass
            );

            newtarget.classList.remove('d-none');
            newtarget.querySelector('.target-id').value = targetId;
            newtarget.querySelector('.target').value = targetDescription;
            newtarget.querySelector('.addactivity').addEventListener('click', addActivity);

            // Retrive Activity from target
            for (let k = 0; k < activityIds.length; k++) {

                var activityId;
                var activityDescription;
                var activityClassification;
                var activityOrder;

                // Get activity info from fields
                for (let l = 0; l < fields[5].arr.length; l++) {

                    if (activityIds[k] == fields[5].arr[l].id) {

                        activityId = fields[5].arr[l].id;
                        activityDescription = fields[5].arr[l].description;

                        activityClassification = data.filter(row => row.mainactivity_id === activityId)[0].classification;
                        activityOrder = data.filter(row => row.mainactivity_id === activityId)[0].activity_order;
                        break;
                    }
                }

                var wrapperactivity = newtarget.querySelector('.wrapperactivity');
                var newactivity = document.querySelector('.containeractivity.d-none').cloneNode(true);
                newactivity.querySelector('i').addEventListener('click', removeActivity);

                autocomplete(
                    newactivity.querySelector(fields[5].target),
                    fields[5].arr,
                    fields[5].hiddenclass
                );

                newactivity.classList.remove('d-none');
                newactivity.classList.add('d-flex');
                newactivity.querySelector('.activity-id').value = activityId;
                newactivity.querySelector('.activity').value = activityDescription;
                newactivity.querySelector('select').value = activityClassification;
                newactivity.querySelector('.activityorder').value = activityOrder;

                wrapperactivity.insertAdjacentElement('afterbegin', newactivity);

            }

            wrappertarget.insertAdjacentElement('afterbegin', newtarget);
        }
    }

    // parse data
    function parseData(data) {
        return JSON.parse(data.replace(/(\r?\n|\r)/g, ' '))
    }

    // data fields
    var fields = [
        { // 0
            target: '.position',
            arr: parseData(window.positions),
            hiddenclass: '.position-id'
        },
        { // 1
            target: '.gradecourse',
            arr: parseData(window.gradeCourses),
            hiddenclass: '.gradecourse-id'
        },
        { // 2
            target: '.competence',
            arr: parseData(window.competences),
            hiddenclass: '.competence-id',
            sizesearch: 3
        },
        { // 3
            target: '.competencelevel',
            arr: parseData(window.competenceLevels)
        },
        { // 4
            target: '.target',
            arr: parseData(window.targets),
            hiddenclass: '.target-id'
        },
        { // 5
            target: '.activity',
            arr: parseData(window.activities),
            hiddenclass: '.activity-id'
        },
        { // 6
            arr: parseData(window.directorates)
        },
    ];

    // clean form fields on page (re)load
    document.querySelector("#formdep").reset();

    // set autocomplete to all fields
    for (let i = 0; i < fields.length; i++) {
        if (fields[i].sizesearch) {
            autocomplete(
                document.querySelector(fields[i].target),
                fields[i].arr,
                fields[i].hiddenclass,
                fields[i].sizesearch
            );
        } else {
            autocomplete(
                document.querySelector(fields[i].target),
                fields[i].arr,
                fields[i].hiddenclass
            );
        }
    }

    // apply event on change
    document.querySelector('.grade').addEventListener('change', filterGradeCourse);
    document.querySelector('.area').addEventListener('change', filterGradeCourse);
    document.querySelector('.competencetype').addEventListener('change', filterByCompetenceType);

    // apply event on click
    document.querySelector('.addgradecourse').addEventListener('click', addGradeCourse);
    document.querySelector('.addlanguage').addEventListener('click', addLanguage);
    document.querySelector('.addcompetence').addEventListener('click', addCompetence);
    document.querySelector('.addtarget').addEventListener('click', addTarget);

    // apply event on submit
    document.querySelector('#formdep').addEventListener('submit', savePositionDescription);

    formFill();

    console.log('validate env')
}

export default init
