#!/bin/bash

_foo() 
{
    local cur prev opts #declatation var locales
    COMPREPLY=()
    cur="${COMP_WORDS[COMP_CWORD]}"
    prev="${COMP_WORDS[COMP_CWORD-1]}"
    opts="--help --verbose --version"

    if [[ ${cur} == -* ]] ; then
        COMPREPLY=( $(compgen -W "${opts}" -- ${cur}) )
        return 0
    fi
}

complete -F _foo foo

  


#2020-11-28 11:07:45 - Exemple pour la completion des dossiers présents
#plusdirs pour inclure les dossiers
  _xyz ()
{
    local IFS=$'\n'
    local LASTCHAR=' '

    COMPREPLY=($(compgen -o plusdirs -f -X '!*.txt' \
        -- "${COMP_WORDS[COMP_CWORD]}"))

    if [ ${#COMPREPLY[@]} = 1 ]; then
        [ -d "$COMPREPLY" ] && LASTCHAR=/
        COMPREPLY=$(printf %q%s "$COMPREPLY" "$LASTCHAR")
    else
        for ((i=0; i < ${#COMPREPLY[@]}; i++)); do
            [ -d "${COMPREPLY[$i]}" ] && COMPREPLY[$i]=${COMPREPLY[$i]}/
        done
    fi

    return 0
}

complete -o nospace -F _xyz xyz


































#enable autocompletion for jump parameter
  _jump ()
{    
        #opts="help verbose version"
        opts="$(ls $HOME/.cache/jumps)"
      COMPREPLY=($(compgen -W "${opts}" \
        -- "${COMP_WORDS[COMP_CWORD]}"))

    local IFS=$'\n'
    local LASTCHAR=' '

    if [ ${#COMPREPLY[@]} = 1 ]; then
        [ -d "$COMPREPLY" ] && LASTCHAR=/
        COMPREPLY=$(printf %q%s "$COMPREPLY" "$LASTCHAR")
    else
        for ((i=0; i < ${#COMPREPLY[@]}; i++)); do
            [ -d "${COMPREPLY[$i]}" ] && COMPREPLY[$i]=${COMPREPLY[$i]}/
        done
    fi
    return 0
}

complete -o nospace -F _jump jump

