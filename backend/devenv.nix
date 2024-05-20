{ pkgs, config, ... }:

{
  # https://devenv.sh/basics/
  env.GREET = "devenv";

  # https://devenv.sh/packages/
  packages = with pkgs; [
    nodePackages.intelephense
    nodePackages.typescript-language-server
    sqlite
  ];

  # https://devenv.sh/scripts/
  scripts.hello.exec = "echo hello from $GREET";

  enterShell = ''
    hello
    git --version
  '';

  # https://devenv.sh/tests/
  enterTest = ''
    echo "Running tests"
    git --version | grep "2.42.0"
  '';

  dotenv.enable = true;

  # https://devenv.sh/services/
  # services.postgres.enable = true;

  # https://devenv.sh/languages/
  languages = {
    nix.enable = true;
    javascript = {
      enable = true;
      package = pkgs.nodejs_21;
      yarn.enable = true;
    };
    php = {
      enable = true;
      extensions = [ "memcached" "xdebug" ];
      ini = ''
        xdebug.mode=debug
        xdebug.client_host=127.0.0.1
        xdebug.client_port=9003
        xdebug.start_with_request=yes
      '';
      version = "83";
    };
  };

  # https://devenv.sh/pre-commit-hooks/
  pre-commit.hooks = {
    nixpkgs-fmt.enable = true;
    php-cs-fixer-custom =
      let
        phpCfg = config.languages.php;
        phpPackages = pkgs."php${phpCfg.version}Packages";
      in
      {
        enable = false;
        entry = ''
          ${phpPackages.php-cs-fixer}/bin/php-cs-fixer fix
        '';
        files = "\\.php$";
      };
    trim-trailing-whitespace.enable = true;
  };

  # https://devenv.sh/processes/
  # processes.ping.exec = "ping example.com";

  # See full reference at https://devenv.sh/reference/options/
}
